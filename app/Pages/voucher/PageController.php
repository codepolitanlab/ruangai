<?php

namespace App\Pages\voucher;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Klaim Voucher',
        'module'     => 'voucher',
        'body_class' => 'rd-dashboard-page',
    ];

    public function getData()
    {
        return $this->respond($this->data);
    }

    public function postRedeem()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $code = strtoupper(trim((string) $this->request->getPost('code')));

        if ($code === '') {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kode voucher wajib diisi.',
            ]);
        }

        $Voucher = new \Course\Models\CourseVoucherModel();
        $result  = $Voucher->claimVoucher($code, (int) $jwt->user_id);

        if (isset($result['error'])) {
            return $this->respond([
                'status'  => 'failed',
                'message' => $result['error'],
            ]);
        }

        return $this->respond([
            'status'  => 'success',
            'message' => 'Voucher berhasil diklaim. Kelas sudah ditambahkan ke Kelas Saya.',
        ]);
    }
}
