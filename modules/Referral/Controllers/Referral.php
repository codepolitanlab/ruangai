<?php

namespace Referral\Controllers;

use Heroicadmin\Controllers\AdminController;
use Referral\Models\ReferralModel;

class Referral extends AdminController
{
    protected $referralModel;

    public function __construct()
    {
        $this->data['page_title'] = 'Referrals';
        $this->data['module']     = 'referral';
        $this->data['submodule']  = 'referrer';

        $this->referralModel = new ReferralModel();
    }

    public function index()
    {
        $this->data = array_merge($this->data, []);

        return view('Referral\Views\referrals\table', $this->data);
    }

    public function table()
    {
        $filters = $this->request->getGet('filter') ?? [];
        $visible = $this->request->getGet('visible') ?? [];
        $page    = max(1, (int) $this->request->getGet('page'));
        $perPage = $this->request->getGet('perpage') ?? 10;

        $builder = $this->referralModel->getFiltered($filters);

        // Select columns
        $select = [];
        $select[] = 'id';
        if (!empty($visible['fullname'])) {
            $select[] = 'fullname';
        }
        if (!empty($visible['email'])) {
            $select[] = 'email';
        }
        if (!empty($visible['referral_code'])) {
            $select[] = 'referral_code';
        }
        if (!empty($visible['referrer_graduate_status'])) {
            $select[] = 'referrer_graduate_status';
        }
        if (!empty($visible['total_referral_graduate'])) {
            $select[] = 'total_referral_graduate';
        }
        if (!empty($visible['amount_referral_graduate'])) {
            $select[] = 'amount_referral_graduate';
        }
        if (!empty($visible['withdrawal'])) {
            $select[] = 'withdrawal';
        }
        if (!empty($visible['balance'])) {
            $select[] = 'balance';
        }

        $builder->select(implode(',', $select));

        // Count total
        $total = $builder->countAllResults(false);

        $builder->limit($perPage, ($page - 1) * $perPage);

        $data['referrals'] = $builder->get()->getResultArray();
        $data['currentPage'] = $page;
        $data['totalPages']  = ceil($total / $perPage);
        $data['visible']     = $visible;

        return view('Referral\Views\referrals\_table_body', $data);
    }
}
