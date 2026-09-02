<?php

namespace Voucher\Controllers;

use Heroicadmin\Controllers\AdminController;

class Sales extends AdminController
{
    public $data = [
        'page_title' => 'Penjualan Voucher',
        'module'     => 'voucher',
        'submodule'  => 'sales',
    ];

    public function index()
    {
        $db      = \Config\Database::connect();
        $perpage = max(1, (int) ($this->request->getGet('perpage') ?: 25));
        $page    = max(1, (int) ($this->request->getGet('page') ?: 1));
        $filter  = $this->request->getGet('filter') ?? [];

        // "Penjualan" = voucher yang sudah dipakai/diklaim member.
        $liveBatchJoin = 'live_batch.id = JSON_UNQUOTE(JSON_EXTRACT(vouchers.metadata, \'$.live_batch_id\'))';

        $apply = static function ($b) use ($filter) {
            if (! empty($filter)) {
                if (! empty($filter['id'])) {
                    $b->where('vouchers.id', (int) $filter['id']);
                }
                if (! empty($filter['name'])) {
                    $b->like('vouchers.name', $filter['name']);
                }
                if (! empty($filter['email'])) {
                    $b->like('vouchers.email', $filter['email']);
                }
                if (! empty($filter['phone'])) {
                    $b->like('vouchers.phone', $filter['phone']);
                }
                if (! empty($filter['voucher_code'])) {
                    $b->like('vouchers.voucher_code', $filter['voucher_code']);
                }
                if (! empty($filter['course_title'])) {
                    $b->like('courses.course_title', $filter['course_title']);
                }
                if (! empty($filter['claimed'])) {
                    $b->like('vouchers.claimed', $filter['claimed']);
                }
            }

            if (! empty($filter['field']) && ! empty($filter['order'])) {
                $orderField = match ($filter['field']) {
                    'id'      => 'vouchers.id',
                    'name'    => 'vouchers.name',
                    'claimed' => 'vouchers.claimed',
                    default   => 'vouchers.claimed',
                };
                $b->orderBy($orderField, $filter['order'] === 'asc' ? 'asc' : 'desc');
            } else {
                $b->orderBy('vouchers.claimed', 'desc');
            }

            return $b;
        };

        // Total
        $countBuilder = $db->table('vouchers')
            ->select('COUNT(DISTINCT vouchers.id) AS total')
            ->join('courses', 'courses.id = vouchers.object_id', 'left')
            ->join('users', 'users.id = vouchers.claimed_by', 'left')
            ->join('live_batch', $liveBatchJoin, 'left')
            ->where('vouchers.deleted_at', null)
            ->where('vouchers.claimed IS NOT NULL', null, false);
        $countBuilder = $apply($countBuilder);
        $countRow     = $countBuilder->get()->getRow();
        $total        = $countRow ? (int) $countRow->total : 0;

        // Data halaman
        $builder = $db->table('vouchers')
            ->select('vouchers.*, courses.course_title, live_batch.name AS live_batch_name, users.email AS claimed_by_email, users.phone AS claimed_by_phone')
            ->join('courses', 'courses.id = vouchers.object_id', 'left')
            ->join('users', 'users.id = vouchers.claimed_by', 'left')
            ->join('live_batch', $liveBatchJoin, 'left')
            ->where('vouchers.deleted_at', null)
            ->where('vouchers.claimed IS NOT NULL', null, false);
        $builder = $apply($builder);

        $vouchers = $builder
            ->limit($perpage, ($page - 1) * $perpage)
            ->get()
            ->getResultArray();

        $this->data['total_vouchers'] = $total;
        $this->data['vouchers']       = $vouchers;
        $this->data['total_pages']    = (int) ceil($total / $perpage);
        $this->data['current_page']   = $page;
        $this->data['perpage']        = $perpage;
        $this->data['filter']         = $filter;

        return view('Voucher\Views\sales\index', $this->data);
    }
}
