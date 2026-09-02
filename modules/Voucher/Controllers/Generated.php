<?php

namespace Voucher\Controllers;

use Heroicadmin\Controllers\AdminController;

class Generated extends AdminController
{
    public $data = [
        'page_title' => 'Daftar Voucher Generate',
        'module'     => 'voucher',
        'submodule'  => 'generated',
    ];

    public function index()
    {
        $db      = \Config\Database::connect();
        $perpage = max(1, (int) ($this->request->getGet('perpage') ?: 25));
        $page    = max(1, (int) ($this->request->getGet('page') ?: 1));
        $filter  = $this->request->getGet('filter') ?? [];

        $liveBatchJoin = 'live_batch.id = JSON_UNQUOTE(JSON_EXTRACT(vouchers.metadata, \'$.live_batch_id\'))';
        $courseJoin    = "courses.id = vouchers.object_id AND vouchers.object_type = 'course'";
        $classJoin     = "cls_classes.id = vouchers.object_id AND vouchers.object_type = 'bootcamp'";

        // List voucher hasil generate internal (owner CODEPOLITAN)
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
                if (! empty($filter['voucher_code'])) {
                    $b->like('vouchers.voucher_code', $filter['voucher_code']);
                }
                if (! empty($filter['course_title'])) {
                    $b->like('courses.course_title', $filter['course_title']);
                }
                if (! empty($filter['created_at'])) {
                    $b->like('vouchers.created_at', $filter['created_at']);
                }
                if (isset($filter['claimed']) && $filter['claimed'] !== '') {
                    if ((int) $filter['claimed'] === 1) {
                        $b->where('vouchers.claimed IS NOT NULL', null, false);
                    } else {
                        $b->where('vouchers.claimed IS NULL', null, false);
                    }
                }
            }

            if (! empty($filter['field']) && ! empty($filter['order'])) {
                $orderField = match ($filter['field']) {
                    'id'           => 'vouchers.id',
                    'name'         => 'vouchers.name',
                    'voucher_code' => 'vouchers.voucher_code',
                    'course_title' => 'COALESCE(cls_classes.name, courses.course_title)',
                    'claimed'      => 'vouchers.claimed',
                    default        => 'vouchers.created_at',
                };
                $b->orderBy($orderField, $filter['order'] === 'asc' ? 'asc' : 'desc');
            } else {
                $b->orderBy('vouchers.created_at', 'desc');
            }

            return $b;
        };

        // Total
        $countBuilder = $db->table('vouchers')
            ->select('COUNT(DISTINCT vouchers.id) AS total')
            ->join('courses', $courseJoin, 'left')
            ->join('cls_classes', $classJoin, 'left')
            ->join('users', 'users.id = vouchers.claimed_by', 'left')
            ->join('live_batch', $liveBatchJoin, 'left')
            ->where('vouchers.deleted_at', null)
            ->where('vouchers.name', 'CODEPOLITAN')
            ->where('vouchers.email', 'codepolitan@gmail.com');
        $countBuilder = $apply($countBuilder);
        $countRow     = $countBuilder->get()->getRow();
        $total        = $countRow ? (int) $countRow->total : 0;

        // Data halaman
        $builder = $db->table('vouchers')
            ->select('vouchers.*, COALESCE(cls_classes.name, courses.course_title) AS course_title, live_batch.name AS batch_name, users.email AS claimed_by_email, users.phone AS claimed_by_phone')
            ->join('courses', $courseJoin, 'left')
            ->join('cls_classes', $classJoin, 'left')
            ->join('users', 'users.id = vouchers.claimed_by', 'left')
            ->join('live_batch', $liveBatchJoin, 'left')
            ->where('vouchers.deleted_at', null)
            ->where('vouchers.name', 'CODEPOLITAN')
            ->where('vouchers.email', 'codepolitan@gmail.com');
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

        return view('Voucher\Views\generated\index', $this->data);
    }

    /**
     * POST /ruangpanel/voucher/generated/delete
     * Soft-delete voucher hasil generate yang belum diklaim.
     */
    public function delete()
    {
        $id = (int) $this->request->getPost('id');

        if (! $id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID tidak valid.']);
        }

        $db = \Config\Database::connect();

        // Hanya boleh hapus voucher yang belum diklaim & berasal dari generate internal
        $voucher = $db->table('vouchers')
            ->select('vouchers.id')
            ->where('vouchers.id', $id)
            ->where('vouchers.deleted_at', null)
            ->where('vouchers.claimed', null)
            ->where('vouchers.name', 'CODEPOLITAN')
            ->where('vouchers.email', 'codepolitan@gmail.com')
            ->get()
            ->getRowArray();

        if (! $voucher) {
            return $this->response->setJSON(['success' => false, 'message' => 'Voucher tidak ditemukan atau sudah diklaim.']);
        }

        $db->table('vouchers')
            ->where('id', $id)
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);

        return $this->response->setJSON(['success' => true, 'message' => 'Voucher berhasil dihapus.']);
    }
}
