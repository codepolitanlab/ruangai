<?php

namespace Webhook\Handlers;

use Course\Models\CourseVoucherModel;
use Throwable;

/**
 * Handler webhook untuk COD EPOLITAN Checkout (CP).
 *
 * Diadaptasi dari app/Pages/webhook_cp/PageController.php (webhook lama) agar
 * logika bisnisnya bisa dijalankan oleh modul Webhook:
 *  - mencatat / mengisi data pembayaran (payments + payment_items) secara idempotent
 *    berdasarkan checkout_code / external_id;
 *  - saat status "PAID": mengaktifkan produk yang dibeli
 *    (course/classroom -> membuat voucher akses + email berisi kode voucher ke pembeli,
 *    pengiriman email non-fatal; classroom -> kode voucher di-redeem member di /bootcamp).
 *
 * Catatan perbaikan dari kode lama:
 *  - CourseVoucherModel berada di namespace Course\Models (kode lama salah memakai App\Models);
 *  - pengiriman email dibuat non-fatal sehingga kegagalan email tidak menggagalkan ACK webhook;
 *  - pembuatan voucher dibuat idempotent (menghindari voucher ganda saat retry/reprocess).
 */
class CodepolitanCheckoutHandler
{
    public function handle(array $payload, array $source = []): array
    {
        $db = \Config\Database::connect();

        try {
            $checkoutCode = $payload['external_id'] ?? null;
            if (! $checkoutCode) {
                return ['success' => false, 'message' => 'Payload tidak memiliki field external_id.'];
            }

            $checkout = is_array($payload['checkout'] ?? null) ? $payload['checkout'] : [];
            $status   = strtoupper((string) ($payload['status'] ?? ($checkout['status'] ?? '')));

            // ------------------------------------------------------------------
            // 1) Pastikan record pembayaran ada (idempotent per checkout_code)
            // ------------------------------------------------------------------
            $existing = $db->table('payments')
                ->where('checkout_code', $checkoutCode)
                ->get()
                ->getRowArray();

            $paymentId = 0;
            if (! $existing) {
                $payment    = $this->buildPayment($checkoutCode, $checkout);
                $db->table('payments')->insert($payment);
                $paymentId = (int) $db->insertID();

                foreach ($this->decodeItems($checkout['items'] ?? null) as $item) {
                    $db->table('payment_items')->insert([
                        'payment_id'   => $paymentId,
                        'item_id'      => $item['reference_id'] ?? null,
                        'item_type'    => $item['type']         ?? null,
                        'title'        => $item['title']        ?? null,
                        'subtitle'     => $item['subtitle']     ?? null,
                        'price'        => $item['price']        ?? 0,
                        'normal_price' => $item['normal_price'] ?? ($item['price'] ?? 0),
                        'quantity'     => $item['quantity']     ?? 1,
                        'subtotal'     => $item['subtotal']     ?? 0,
                    ]);
                }
            } else {
                $paymentId = (int) $existing['id'];
            }

            // ------------------------------------------------------------------
            // 2) Bila status PAID: aktifkan produk yang dibeli
            // ------------------------------------------------------------------
            $activation = ['activated' => 0, 'skipped' => 0, 'detail' => []];
            if ($status === 'PAID') {
                $activation = $this->activateProducts($paymentId);

                // Email receipt (hanya saat record pembayaran baru dibuat)
                if ($paymentId && ! $existing) {
                    $paymentRow = $db->table('payments')->where('id', $paymentId)->get()->getRowArray();
                    $this->sendReceiptEmail($paymentRow ?: []);
                }
            }

            return [
                'success' => true,
                'message' => 'Webhook CP diproses.',
                'data'    => [
                    'payment_id' => $paymentId,
                    'status'     => $status,
                    'activation' => $activation,
                ],
            ];
        } catch (Throwable $e) {
            log_message('error', '[Webhook-CP] ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());

            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function buildPayment(string $checkoutCode, array $c): array
    {
        return [
            'checkout_code'    => $checkoutCode,
            'status'           => $c['status']           ?? null,
            'client_code'      => $c['client_code']       ?? null,
            'customer_id'      => $c['customer_id']       ?? null,
            'customer_name'    => $c['customer_name']     ?? null,
            'customer_email'   => $c['customer_email']    ?? null,
            'customer_phone'   => $c['customer_phone']    ?? null,
            'customer_address' => $c['customer_address']  ?? null,
            'description'      => $c['description']       ?? null,
            'amount_items'     => $c['amount_items']      ?? 0,
            'discount'         => $c['discount']          ?? 0,
            'subtotal'         => $c['subtotal']          ?? 0,
            'payment_method'   => $c['payment_method']    ?? null,
            'payment_fee'      => $c['payment_fee']       ?? 0,
            'shipping_fee'     => $c['shipping_fee']      ?? 0,
            'tax'              => $c['tax']               ?? 0,
            'total'            => $c['total']             ?? 0,
            'created_at'       => $c['created_at']        ?? date('Y-m-d H:i:s'),
            'updated_at'       => $c['updated_at']        ?? null,
            'deleted_at'       => $c['deleted_at']        ?? null,
        ];
    }

    private function decodeItems($items): array
    {
        if (is_array($items)) {
            return $items;
        }
        if (is_string($items)) {
            $decoded = json_decode($items, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    /**
     * Aktifkan tiap item pembayaran dengan activator dinamis _activate{Type}.
     */
    private function activateProducts(int $paymentId): array
    {
        $db = \Config\Database::connect();

        $items = $db->table('payment_items')
            ->where('payment_id', $paymentId)
            ->get()
            ->getResultArray();

        $result = ['activated' => 0, 'skipped' => 0, 'detail' => []];

        foreach ($items as $item) {
            $type       = ucfirst((string) ($item['item_type'] ?? ''));
            $methodName = '_activate' . $type;

            if (! method_exists($this, $methodName)) {
                $result['skipped']++;
                $result['detail'][] = [
                    'item'    => $item['title'] ?? '',
                    'status'  => 'skipped',
                    'message' => "Tidak ada activator untuk tipe '{$item['item_type']}'.",
                ];
                continue;
            }

            try {
                $out = $this->{$methodName}($paymentId, $item);
                $result[$out['status'] === 'success' ? 'activated' : 'skipped']++;
                $result['detail'][] = [
                    'item'    => $item['title'] ?? '',
                    'status'  => $out['status'],
                    'message' => $out['message'] ?? '',
                ];
            } catch (Throwable $e) {
                log_message('error', '[Webhook-CP] Gagal aktivasi item: ' . $e->getMessage());

                $result['skipped']++;
                $result['detail'][] = [
                    'item'    => $item['title'] ?? '',
                    'status'  => 'failed',
                    'message' => $e->getMessage(),
                ];
            }
        }

        return $result;
    }

    /**
     * Course -> buat voucher akses untuk customer (replikasi _activateCourse lama).
     */
    private function _activateCourse(int $paymentId, array $item): array
    {
        $db = \Config\Database::connect();

        $payment = $db->table('payments')->where('id', $paymentId)->get()->getRowArray();
        if (! $payment) {
            return ['status' => 'failed', 'message' => 'Data pembayaran tidak ditemukan.'];
        }

        $name  = trim((string) ($payment['customer_name'] ?? ''));
        $email = strtolower(trim((string) ($payment['customer_email'] ?? '')));
        if ($name === '' || $email === '') {
            return ['status' => 'failed', 'message' => 'Data customer (nama/email) tidak lengkap.'];
        }

        $heroic = new \App\Libraries\Heroic();
        $phone  = $heroic->normalizePhoneNumber($payment['customer_phone'] ?? '');

        $courseProduct = $db->table('course_products')->where('id', $item['item_id'])->get()->getRowArray();
        if (! $courseProduct) {
            return ['status' => 'failed', 'message' => "Course product #{$item['item_id']} tidak ditemukan."];
        }

        $user = ['name' => $name, 'email' => $email, 'phone' => $phone];
        $meta = [
            'duration'      => $courseProduct['duration'] ?? 0,
            'live_batch_id' => $courseProduct['live_batch_id'] ?? ($courseProduct['join_intensive'] ?? 0),
        ];

        // preventDuplicate = true agar aktivasi idempotent (tidak membuat voucher ganda)
        $voucher = (new CourseVoucherModel())->createVoucher((int) $courseProduct['course_id'], $user, $meta, true);

        if (isset($voucher['error'])) {
            // Voucher sudah pernah dibuat untuk kombinasi ini -> anggap sukses (idempotent)
            if (stripos((string) $voucher['error'], 'sudah pernah dibuat') !== false) {
                return ['status' => 'success', 'message' => 'Voucher sudah ada sebelumnya (idempotent).'];
            }

            return ['status' => 'failed', 'message' => $voucher['error']];
        }

        $this->sendVoucherEmail($user, $voucher, $courseProduct);

        return [
            'status'  => 'success',
            'message' => 'Voucher dibuat: ' . ($voucher['voucher_code'] ?? ''),
        ];
    }

    /**
     * Classroom -> buat voucher akses kelas (object_type 'bootcamp') untuk pembeli,
     * lalu kirim kode voucher ke email pembeli (meniru _activateCourse). Member
     * kemudian me-redeem kode tersebut di halaman /bootcamp untuk masuk ke kelas.
     *
     * Idempotent: bila voucher sudah pernah dibuat untuk kombinasi email + kelas,
     * tidak membuat voucher baru — kode yang sama dikirim ulang ke email pembeli
     * (menjamin kode tetap sampai meski pengiriman email pertama gagal).
     */
    private function _activateClassroom(int $paymentId, array $item): array
    {
        $db = \Config\Database::connect();

        $payment = $db->table('payments')->where('id', $paymentId)->get()->getRowArray();
        if (! $payment) {
            return ['status' => 'failed', 'message' => 'Data pembayaran tidak ditemukan.'];
        }

        $name  = trim((string) ($payment['customer_name'] ?? ''));
        $email = strtolower(trim((string) ($payment['customer_email'] ?? '')));
        if ($name === '' || $email === '') {
            return ['status' => 'failed', 'message' => 'Data customer (nama/email) tidak lengkap.'];
        }

        $phone = trim((string) ($payment['customer_phone'] ?? ''));

        $classProduct = $db->table('cls_products')
            ->where('id', $item['item_id'])
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();
        if (! $classProduct) {
            return ['status' => 'failed', 'message' => "Class product #{$item['item_id']} tidak ditemukan."];
        }

        if ((int) ($classProduct['status'] ?? 1) !== 1) {
            return ['status' => 'failed', 'message' => 'Produk kelas nonaktif, tidak dapat diaktifkan.'];
        }

        $class = $db->table('cls_classes')
            ->where('id', $classProduct['class_id'])
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();
        if (! $class) {
            return ['status' => 'failed', 'message' => 'Kelas bootcamp tidak ditemukan.'];
        }

        $classId = (int) $classProduct['class_id'];

        // Voucher kelas bootcamp memakai object_type 'bootcamp' (konvensi modul Voucher
        // & endpoint redeem /bootcamp/redeem); object_id = cls_classes.id.
        $existing = $db->table('vouchers')
            ->where('email', $email)
            ->where('object_id', $classId)
            ->where('object_type', 'bootcamp')
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        if ($existing) {
            // Idempotent: kirim ulang kode yang sama (hindari voucher ganda saat retry/reprocess)
            $this->sendBootcampVoucherEmail([
                'name'         => $name,
                'email'        => $email,
                'phone'        => $phone,
                'voucher_code' => $existing['voucher_code'],
            ], $classProduct, $class);

            return [
                'status'  => 'success',
                'message' => 'Voucher kelas sudah ada (idempotent): ' . $existing['voucher_code'],
            ];
        }

        // Generate kode voucher unik & simpan
        $voucherCode = $this->generateVoucherCode();
        if ($voucherCode === null) {
            return ['status' => 'failed', 'message' => 'Gagal menghasilkan kode voucher unik.'];
        }

        $db->table('vouchers')->insert([
            'object_id'    => $classId,
            'object_type'  => 'bootcamp',
            'voucher_code' => $voucherCode,
            'name'         => $name,
            'email'        => $email,
            'phone'        => $phone,
            'metadata'     => json_encode(['duration' => '0']),
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        $this->sendBootcampVoucherEmail([
            'name'         => $name,
            'email'        => $email,
            'phone'        => $phone,
            'voucher_code' => $voucherCode,
        ], $classProduct, $class);

        return [
            'status'  => 'success',
            'message' => 'Voucher kelas dibuat: ' . $voucherCode,
        ];
    }

    /**
     * Buat kode voucher unik (karakter tanpa karakter ambigu), memeriksa keunikan
     * di tabel vouchers.
     */
    private function generateVoucherCode(int $length = 8): ?string
    {
        $characters  = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // tanpa 0, O, o, l, 1, I
        $maxAttempts = 10;
        $db          = \Config\Database::connect();

        for ($i = 0; $i < $maxAttempts; $i++) {
            $code = '';
            for ($j = 0; $j < $length; $j++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }

            $exists = $db->table('vouchers')
                ->where('voucher_code', $code)
                ->where('deleted_at IS NULL')
                ->countAllResults();

            if (! $exists) {
                return $code;
            }
        }

        return null;
    }

    /**
     * Kirim email berisi kode voucher akses bootcamp (template: emails/bootcamp_voucher).
     */
    private function sendBootcampVoucherEmail(array $user, array $classProduct, array $class): void
    {
        try {
            $emailSender = new \App\Libraries\EmailSender();
            $emailSender->setTemplate('bootcamp_voucher', [
                'name'          => $user['name'],
                'email'         => $user['email'],
                'phone'         => $user['phone'],
                'voucher_code'  => $user['voucher_code'],
                'class_name'    => $class['name'] ?? '',
                'product_title' => $classProduct['title'] ?? '',
            ]);
            $emailSender->send($user['email'], 'Kode Akses Kelas Bootcamp: ' . ($classProduct['title'] ?? ''));
        } catch (Throwable $e) {
            log_message('error', '[Webhook-CP] Gagal kirim email voucher bootcamp: ' . $e->getMessage());
        }
    }

    private function sendVoucherEmail(array $user, array $voucher, array $courseProduct): void
    {
        try {
            $emailSender = new \App\Libraries\EmailSender();
            $emailSender->setTemplate('course_voucher_generated', [
                'name'         => $user['name'],
                'email'        => $user['email'],
                'phone'        => $user['phone'],
                'voucher'      => $voucher,
                'voucher_code' => $voucher['voucher_code'] ?? '',
                'course'       => $courseProduct['title'] ?? '',
                'course_title' => $courseProduct['title'] ?? '',
            ]);
            $emailSender->send($user['email'], 'Pendaftaran Kelas ' . ($courseProduct['title'] ?? ''));
        } catch (Throwable $e) {
            log_message('error', '[Webhook-CP] Gagal kirim email voucher: ' . $e->getMessage());
        }
    }

    private function sendReceiptEmail(array $payment): void
    {
        try {
            $emailSender = new \App\Libraries\EmailSender();
            $emailSender->setTemplate('payment_received', $payment);
            $emailSender->send((string) ($payment['customer_email'] ?? ''), 'Pembayaran Diterima');
        } catch (Throwable $e) {
            log_message('error', '[Webhook-CP] Gagal kirim email receipt: ' . $e->getMessage());
        }
    }
}
