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

        // Kelas yang sedang aktif diikuti user — produknya tidak perlu ditampilkan lagi
        $enrolledClassIds = array_column($classes, 'id');

        // Produk kelas aktif yang bisa dibeli (status produk = 1 & kelasnya active)
        $productRows = $db->table('cls_products p')
            ->select('p.*, c.name AS class_name, c.thumbnail AS class_thumbnail, c.description AS class_description, c.start_date AS class_start_date, s.name AS syllabus_name')
            ->join('cls_classes c', 'c.id = p.class_id')
            ->join('cls_syllabuses s', 's.id = c.syllabus_id', 'left')
            ->where('p.status', 1)
            ->where('p.deleted_at IS NULL')
            ->where('c.status', 'active')
            ->where('c.deleted_at IS NULL')
            ->orderBy('p.id', 'DESC')
            ->get()
            ->getResultArray();

        // Jumlah materi (pertemuan) per kelas untuk ditampilkan sebagai pengganti durasi akses
        $materialCounts = [];
        $matRows        = $db->table('cls_class_materials')
            ->select('class_id, COUNT(*) AS total')
            ->groupBy('class_id')
            ->get()
            ->getResultArray();
        foreach ($matRows as $matRow) {
            $materialCounts[(int) $matRow['class_id']] = (int) $matRow['total'];
        }

        $products = [];
        foreach ($productRows as $prod) {
            // Lewati kelas yang sudah aktif diikuti user
            if (in_array((int) $prod['class_id'], $enrolledClassIds, true)) {
                continue;
            }
            $products[] = [
                'id'                => (int) $prod['id'],
                'class_id'          => (int) $prod['class_id'],
                'title'             => $prod['title'],
                'subtitle'          => $prod['subtitle'],
                'description'       => $prod['description'],
                'price'             => (int) $prod['price'],
                'normal_price'      => (int) $prod['normal_price'],
                'discount'          => (int) $prod['discount'],
                'material_count'    => $materialCounts[(int) $prod['class_id']] ?? 0, // jumlah pertemuan
                'class_name'        => $prod['class_name'],
                'class_thumbnail'   => $prod['class_thumbnail'],
                'class_description' => $prod['class_description'],
                'class_start_date'  => $prod['class_start_date'],
                'syllabus_name'     => $prod['syllabus_name'],
            ];
        }

        $this->data['classes']  = $classes;
        $this->data['products'] = $products;
        $this->data['user']     = [
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
     * POST /bootcamp/checkout — buat link pembayaran (CPCheckout) untuk produk kelas aktif.
     */
    public function postCheckout()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        $productId = (int) $this->request->getPost('product_id');
        if ($productId < 1) {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Produk tidak valid.',
            ]);
        }

        // Produk kelas aktif (status produk = 1 & kelasnya active, tidak dihapus)
        $product = $db->table('cls_products p')
            ->select('p.*, c.status AS class_status')
            ->join('cls_classes c', 'c.id = p.class_id')
            ->where('p.id', $productId)
            ->where('p.status', 1)
            ->where('p.deleted_at IS NULL')
            ->where('c.status', 'active')
            ->where('c.deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $product) {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Produk tidak tersedia.',
            ]);
        }

        // Hindari pembelian ganda untuk kelas yang sedang aktif diikuti
        $isMember = $db->table('cls_class_members')
            ->where('class_id', $product['class_id'])
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->countAllResults();

        if ($isMember > 0) {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Anda sudah terdaftar di kelas ini.',
            ]);
        }

        // Item produk untuk CPCheckout (mirror Product::checkout pada modul Classroom).
        // Diskon dipakai di summary checkout, jadi price dikirim = normal_price.
        $item          = $product;
        $item['type']  = 'classroom';
        $item['price'] = $product['normal_price'];

        $CPCheckout = new \App\Libraries\CPCheckout();
        $response   = $CPCheckout->getCheckoutUrl([$item], [], [
            'discount'             => (int) $product['discount'],
            'exp_duration'         => $product['exp_duration'] ?? 86400,
            'success_redirect_url' => site_url('bootcamp'),
        ]);

        if (! isset($response['url'])) {
            return $this->respondSecure([
                'status'  => 'failed',
                'message' => 'Gagal membuat link pembayaran. Silakan coba lagi.',
            ]);
        }

        return $this->respondSecure([
            'status' => 'success',
            'url'    => $response['url'],
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
