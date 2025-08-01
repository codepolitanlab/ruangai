<?php

namespace Course\Models;

use CodeIgniter\Model;
use RuntimeException;

class CourseVoucherModel extends Model
{
    protected $table            = 'vouchers';
    protected $primaryKey       = 'id';
    private $objectType         = 'course';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'object_id',
        'object_type',
        'voucher_code',
        'name',
        'email',
        'phone',
        'metadata',
        'claimed_by',
        'claimed',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validasi input user
    protected $validationRules = [
        'name'  => 'required|string|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[255]',
        'phone' => 'required|string|min_length[8]|max_length[20]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Nama wajib diisi.',
        ],
        'email' => [
            'required'    => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
        ],
        'phone' => [
            'required' => 'Nomor WhatsApp wajib diisi.',
        ],
    ];

    public function createVoucher(int $course_id, array $user, array $meta = [], bool $preventDuplicate = true): ?array
    {
        // Validasi input user
        $validation = service('validation');
        $validation->setRules($this->validationRules, $this->validationMessages);

        // Validasi dasar
        if (! $validation->run($user)) {
            return ['error' => implode(', ', $validation->getErrors())];
        }

        // Cek apakah voucher sudah pernah dibuat untuk kombinasi ini
        if ($preventDuplicate) {
            $existing = $this->where([
                'email'       => $user['email'],
                'object_id'   => $course_id,
                'object_type' => $this->objectType,
            ])->first();

            if ($existing) {
                return ['error' => 'Voucher sudah pernah dibuat untuk user ini.'];
            }
        }

        // Generate kode unik
        $voucherCode = $this->generateUniqueVoucherCode();

        // Simpan data
        $data = [
            'object_id'    => $course_id,
            'object_type'  => $this->objectType,
            'voucher_code' => $voucherCode,
            'name'         => $user['name'],
            'email'        => $user['email'],
            'phone'        => $user['phone'],
            'metadata'     => json_encode($meta),
        ];

        // Simpan voucher
        $this->insert($data);

        return $this->where('voucher_code', $voucherCode)->first();
    }

    protected function generateUniqueVoucherCode(int $length = 8): string
    {
        $characters  = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Tanpa 0, o, O, l, 1, I
        $maxAttempts = 5;

        for ($i = 0; $i < $maxAttempts; $i++) {
            $code = '';

            for ($j = 0; $j < $length; $j++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }

            if (! $this->where('voucher_code', $code)->where('claimed', null)->first()) {
                return $code;
            }
        }

        throw new RuntimeException('Gagal menghasilkan kode voucher unik setelah beberapa kali percobaan.');
    }

    // Claim voucher
    public function claimVoucher(string $voucherCode, int $claimedBy): ?array
    {
        $voucher = $this->where('voucher_code', $voucherCode)->first();

        if (! $voucher) {
            return ['error' => 'Kode voucher tidak ditemukan.'];
        }

        if ($voucher['object_type'] !== 'course') {
            return ['error' => 'Voucher tidak valid [not-course].'];
        }

        if ($voucher['claimed']) {
            return ['error' => 'Kode voucher sudah pernah diklaim.'];
        }

        // Register user to course_students
        $db              = \Config\Database::connect();
        $voucherMetadata = json_decode($voucher['metadata'] ?? '[]', true);
        $db->table('course_students')->insert([
            'user_id'   => $claimedBy,
            'course_id' => $voucher['object_id'],
            'expire_at' => (int) ($voucherMetadata['duration'] ?? 0) === 0 ? '2999-12-31 00:00:00' : date('Y-m-d H:i:s', strtotime('+' . $voucherMetadata['duration'] . ' days')),
            // 'join_intensive' => ($voucherMetadata['join_intensive'] ?? false) ? 1 : 0,
            'live_batch_id' => $voucherMetadata['live_batch_id'] ?? null,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        // Set claimed
        $this->update($voucher['id'], ['claimed' => date('Y-m-d H:i:s'), 'claimed_by' => $claimedBy]);

        return $voucher;
    }
}
