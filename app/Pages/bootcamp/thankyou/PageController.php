<?php

namespace App\Pages\bootcamp\thankyou;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Thank You - Bootcamp',
        'module'     => 'bootcamp',
        'active_page' => 'bootcamp',
        'body_class' => 'rd-dashboard-page',
    ];

    /**
     * GET /bootcamp/thankyou/data/{checkout_code}
     *
     * Halaman publik "terima kasih" setelah pembayaran bootcamp sukses.
     * Berdasarkan kode checkout (external_id dari CPCheckout) dicari:
     *  1. record pembayaran      (payments.checkout_code)
     *  2. produk kelas yang dibeli (payment_items.item_type = 'classroom')
     *  3. voucher akses bootcamp  (vouchers object_type='bootcamp') milik pembeli utk kelas tsb
     *
     * Bila tidak ditemukan (kode invalid / belum PAID / bukan bootcamp) -> 404.
     */
    public function getData($checkout_code = null)
    {
        $code = trim((string) $checkout_code);
        if ($code === '') {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Kode checkout tidak valid.',
            ], 404);
        }

        $db = \Config\Database::connect();

        // 1) Cari payment berdasarkan checkout_code
        $payment = $db->table('payments')
            ->where('checkout_code', $code)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $payment) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Transaksi tidak ditemukan.',
            ], 404);
        }

        // 2) Cari item classroom pada payment -> cls_products -> kelas
        $item = $db->table('payment_items pi')
            ->select('pi.*, p.class_id AS product_class_id, p.title AS product_title')
            ->join('cls_products p', 'p.id = pi.item_id AND p.deleted_at IS NULL', 'left')
            ->where('pi.payment_id', $payment['id'])
            ->where('pi.item_type', 'classroom')
            ->orderBy('pi.id', 'ASC')
            ->get()
            ->getRowArray();

        if (! $item || empty($item['product_class_id'])) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Transaksi bukan pembelian bootcamp.',
            ], 404);
        }

        $classId = (int) $item['product_class_id'];

        $class = $db->table('cls_classes')
            ->where('id', $classId)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $class) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Kelas bootcamp tidak ditemukan.',
            ], 404);
        }

        // 3) Cari voucher akses bootcamp milik pembeli untuk kelas ini
        $voucher = null;
        $email   = strtolower(trim((string) ($payment['customer_email'] ?? '')));
        if ($email !== '') {
            $voucher = $db->table('vouchers')
                ->where('email', $email)
                ->where('object_type', 'bootcamp')
                ->where('object_id', $classId)
                ->where('deleted_at IS NULL')
                ->orderBy('id', 'DESC')
                ->get()
                ->getRowArray();
        }

        if (! $voucher) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Kode akses bootcamp belum tersedia. Silakan cek email kamu.',
            ], 404);
        }

        // Nama produk/kelas utk tampilan (fallback ke nama kelas bila produk dihapus)
        $productTitle = trim((string) ($item['product_title'] ?? ''));
        if ($productTitle === '') {
            $productTitle = (string) ($class['name'] ?? 'Bootcamp');
        }

        return $this->respond([
            'status'        => 'success',
            'name'          => (string) ($voucher['name'] ?: ($payment['customer_name'] ?? '')),
            'product_title' => $productTitle,
            'class_name'    => (string) ($class['name'] ?? ''),
            'class_id'      => $classId,
            'voucher_code'  => (string) $voucher['voucher_code'],
            'claimed'       => ! empty($voucher['claimed']),
            'claim_url'     => '/voucher',
            'bootcamp_url'  => '/bootcamp',
        ]);
    }
}
