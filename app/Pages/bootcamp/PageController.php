<?php

namespace App\Pages\bootcamp;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Bootcamp',
        'module'     => 'bootcamp',
        'active_page' => 'bootcamp',
        'body_class' => 'rd-dashboard-page',
    ];

    /**
     * GET /bootcamp/data — daftar "Kelas Saya" untuk user yang login.
     */
    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        // Kelas aktif milik user (JOIN keanggotaan)
        $classes = $db->table('cls_classes c')
            ->select('c.*, cm.enrolled_at, cm.role AS member_role, s.name AS syllabus_name')
            ->join('cls_class_members cm', 'cm.class_id = c.id AND cm.user_id = ' . $userId, 'left')
            ->join('cls_syllabuses s', 's.id = c.syllabus_id', 'left')
            ->where('cm.user_id', $userId)
            ->where('cm.status', 'active')
            ->where('c.status', 'active')
            ->where('c.deleted_at IS NULL')
            ->orderBy('c.start_date', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($classes as &$cls) {
            $cls['total_materials'] = (int) $db->table('cls_class_materials')
                ->where('class_id', $cls['id'])
                ->countAllResults();
            $cls['progress'] = $this->classProgress($db, (int) $cls['id'], $userId);
        }
        unset($cls);

        $this->data['classes'] = $classes;
        $this->data['user']    = [
            'name'  => $jwt->user['name'] ?? '',
            'email' => $jwt->user['email'] ?? '',
        ];

        return $this->respondSecure($this->data);
    }

    /**
     * POST /bootcamp/redeem — klaim kode akses kelas (voucher product classroom).
     */
    public function postRedeem()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        $code = strtoupper(trim((string) $this->request->getPost('code')));

        if ($code === '') {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Kode akses wajib diisi.',
            ]);
        }

        $voucher = $db->table('vouchers')
            ->where('voucher_code', $code)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $voucher) {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Kode akses tidak ditemukan.',
            ]);
        }

        // Voucher kelas bootcamp memakai object_type 'bootcamp'.
        if (($voucher['object_type'] ?? '') !== 'bootcamp') {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Kode akses bukan untuk kelas bootcamp.',
            ]);
        }

        if (! empty($voucher['claimed'])) {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Kode akses sudah pernah dipakai.',
            ]);
        }

        // Cek kepemilikan: email/phone di voucher harus cocok dengan user login
        $userEmail = strtolower(trim((string) ($jwt->user['email'] ?? '')));
        $userPhone = preg_replace('/[^0-9]/', '', (string) ($jwt->user['phone'] ?? ''));
        $vEmail    = strtolower(trim((string) ($voucher['email'] ?? '')));
        $vPhone    = preg_replace('/[^0-9]/', '', (string) ($voucher['phone'] ?? ''));

        if ($vEmail !== '' && $vEmail !== $userEmail) {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Kode akses tidak berlaku untuk akun ini.',
            ]);
        }
        if ($vPhone !== '' && $vPhone !== $userPhone) {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Kode akses tidak berlaku untuk akun ini.',
            ]);
        }

        // Kelas harus aktif
        $classId = (int) $voucher['object_id'];
        $class   = $db->table('cls_classes')
            ->where('id', $classId)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $class || $class['status'] !== 'active') {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Kelas bootcamp belum tersedia.',
            ]);
        }

        // Enroll / reaktivasi
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

        return $this->respondSecure([
            'status'   => 'success',
            'message'  => 'Kode akses berhasil dipakai. Kelas ditambahkan ke Kelas Saya.',
            'class_id' => $classId,
        ]);
    }

    /**
     * Progres user dalam satu kelas: completed resource wajib / total resource wajib.
     */
    private function classProgress($db, int $classId, int $userId): array
    {
        $cmRows = $db->table('cls_class_materials')
            ->select('id')
            ->where('class_id', $classId)
            ->get()
            ->getResultArray();

        $cmIds = array_column($cmRows, 'id');

        if (! $cmIds) {
            return ['percent' => 0, 'completed' => 0, 'total' => 0];
        }

        $required = $db->table('cls_learning_resources r')
            ->join('cls_class_materials cm', 'cm.material_id = r.material_id')
            ->whereIn('cm.id', $cmIds)
            ->where('r.is_required', 1)
            ->where('r.deleted_at IS NULL')
            ->countAllResults();

        // Hanya resource WAJIB yang selesai (konsisten dgn halaman belajar)
        $completed = $db->table('cls_learning_resources r')
            ->join('cls_class_materials cm', 'cm.material_id = r.material_id')
            ->join('cls_learning_progress p', 'p.resource_id = r.id AND p.class_material_id = cm.id AND p.user_id = ' . $userId)
            ->whereIn('cm.id', $cmIds)
            ->where('r.is_required', 1)
            ->where('r.deleted_at IS NULL')
            ->where('p.status', 'completed')
            ->countAllResults();

        $percent = $required > 0 ? (int) round(($completed / $required) * 100) : 0;

        return ['percent' => $percent, 'completed' => $completed, 'total' => $required];
    }
}
