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
        $userId = (int) $jwt->user_id;

        $code = strtoupper(trim((string) $this->request->getPost('code')));

        if ($code === '') {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kode voucher wajib diisi.',
            ]);
        }

        $db = \Config\Database::connect();

        $voucher = $db->table('vouchers')
            ->where('voucher_code', $code)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $voucher) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kode voucher tidak ditemukan.',
            ]);
        }

        if (! empty($voucher['claimed'])) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kode voucher sudah pernah diklaim.',
            ]);
        }

        // Voucher kelas bootcamp (object_type 'bootcamp')
        // -> daftarkan member ke cls_class_members.
        if (($voucher['object_type'] ?? '') === 'bootcamp') {
            $classId = (int) $voucher['object_id'];
            $class   = $db->table('cls_classes')
                ->where('id', $classId)
                ->where('deleted_at IS NULL')
                ->get()
                ->getRowArray();

            if (! $class || $class['status'] !== 'active') {
                return $this->respond([
                    'status'  => 'failed',
                    'message' => 'Kelas bootcamp belum tersedia.',
                ]);
            }

            // Enroll / reaktivasi peserta
            $member = $db->table('cls_class_members')
                ->where('class_id', $classId)
                ->where('user_id', $userId)
                ->get()
                ->getRowArray();

            if ($member) {
                $db->table('cls_class_members')
                    ->where('id', $member['id'])
                    ->update(['status' => 'active', 'role' => 'member']);
            } else {
                $db->table('cls_class_members')->insert([
                    'class_id' => $classId,
                    'user_id'  => $userId,
                    'role'     => 'member',
                    'status'   => 'active',
                ]);
            }

            // Tandai voucher sudah dipakai
            $db->table('vouchers')
                ->where('id', $voucher['id'])
                ->update(['claimed' => date('Y-m-d H:i:s'), 'claimed_by' => $userId]);

            return $this->respond([
                'status'  => 'success',
                'message' => 'Kode voucher berhasil dipakai. Kelas bootcamp ditambahkan ke Kelas Saya.',
            ]);
        }

        // Voucher online course -> daftarkan ke course_students.
        $Voucher = new \Course\Models\CourseVoucherModel();
        $result  = $Voucher->claimVoucher($code, $userId);

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
