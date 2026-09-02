<?php

namespace App\Pages\webhook_cp;

use App\Pages\BaseController;
use Exception;

class PageController extends BaseController
{
    // Appkey from CODEPOLITAN Checkout
    private $cpAppKey = '6bafa473a0eef42540d15657a7c906255bb8e165f8b22e56daee4e11301e02d5';

    public function getIndex()
    {
        return $this->respond('Unauthorized', 401);
    }

    public function postIndex($token = null)
    {
        // Validate incoming webhook by appkey
        if (strcmp($_SERVER['HTTP_X_CALLBACK_TOKEN'] ?? '', $this->cpAppKey) !== 0) {
            return $this->respond('Unauthorized', 401);
        }

        // Handle CP Checkout callback
        $payload          = file_get_contents('php://input');
        $webhook_callback = json_decode($payload, true);
        $checkout_code    = $webhook_callback['external_id'];

        // Check payment by code if exists
        $db      = \Config\Database::connect();
        $payment = $db->table('payments')->where('checkout_code', $checkout_code)->get()->getRowArray();

        if ($payment['id'] ?? null) {
            $payment['items'] = json_decode($webhook_callback['checkout']['items'], true);
        } else {
            $payment['checkout_code']    = $checkout_code;
            $payment['status']           = $webhook_callback['checkout']['status'];
            $payment['client_code']      = $webhook_callback['checkout']['client_code'];
            $payment['customer_id']      = $webhook_callback['checkout']['customer_id'];
            $payment['customer_name']    = $webhook_callback['checkout']['customer_name'];
            $payment['customer_email']   = $webhook_callback['checkout']['customer_email'];
            $payment['customer_phone']   = $webhook_callback['checkout']['customer_phone'];
            $payment['customer_address'] = $webhook_callback['checkout']['customer_address'];
            $payment['description']      = $webhook_callback['checkout']['description'];
            $payment['amount_items']     = $webhook_callback['checkout']['amount_items'];
            $payment['discount']         = $webhook_callback['checkout']['discount'];
            $payment['subtotal']         = $webhook_callback['checkout']['subtotal'];
            $payment['payment_method']   = $webhook_callback['checkout']['payment_method'];
            $payment['shipping_fee']     = $webhook_callback['checkout']['shipping_fee'];
            $payment['payment_fee']      = $webhook_callback['checkout']['payment_fee'];
            $payment['tax']              = $webhook_callback['checkout']['tax'];
            $payment['total']            = $webhook_callback['checkout']['total'];
            $payment['created_at']       = $webhook_callback['checkout']['created_at'];
            $payment['updated_at']       = $webhook_callback['checkout']['updated_at'];
            $payment['deleted_at']       = $webhook_callback['checkout']['deleted_at'];

            // Insert new transaction to table payments
            $db->table('payments')->insert($payment);

            $payment['id']    = $db->insertID();
            $payment['items'] = json_decode($webhook_callback['checkout']['items'], true);

            foreach ($payment['items'] as $item) {
                $db->table('payment_items')->insert([
                    'payment_id'   => $payment['id'],
                    'item_id'      => $item['reference_id'],
                    'item_type'    => $item['type'],
                    'title'        => $item['title'],
                    'subtitle'     => $item['subtitle'],
                    'price'        => $item['price'],
                    'normal_price' => $item['normal_price'],
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $item['subtotal'],
                ]);
            }

            // Kirim email receipt pembayaran
            if ($webhook_callback['status'] === 'PAID') {
                $EmailSender = new \App\Libraries\EmailSender();
                $EmailSender->setTemplate('payment_received', array_merge($this->data, $payment));
                $EmailSender->send($payment['customer_email'], 'Pembayaran Diterima');
            }
        }

        // Handle paid invoice
        if ($webhook_callback['status'] === 'PAID') {
            $this->activatePaymentProducts($payment);
        }

        $this->logWebhook($webhook_callback['external_id'], $payload);

        return $this->respond(['status' => 'success']);
    }

    private function logWebhook($code, $payload)
    {
        $db = \Config\Database::connect();
        $db->table('payment_webhook_logs')->insert([
            'code'       => $code,
            'payload'    => $payload,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function activatePaymentProducts($payment)
    {
        // Get payment items
        $db           = \Config\Database::connect();
        $paymentItems = $db->table('payment_items')->where('payment_id', $payment['id'])->get()->getResultArray();

        foreach ($paymentItems as $item) {
            $type       = ucfirst($item['item_type']);
            $methodName = "_activate{$type}";
            if (method_exists($this, $methodName)) {
                $this->{$methodName}($payment, $item);
            }
        }

        return true;
    }

    // Dynamic calling method from activatePaymentProducts
    private function _activateCourse($payment, $item)
    {
        // Create user voucher for the course
        $name   = trim($payment['customer_name']);
        $email  = strtolower($payment['customer_email']);
        $Heroic = new \App\Libraries\Heroic();
        $phone  = $Heroic->normalizePhoneNumber($payment['customer_phone']);

        // Create data voucher untuk course_id 1
        $user = [
            'name'  => $name,
            'email' => $email,
            'phone' => $phone,
        ];

        // Get course product by id
        $db            = \Config\Database::connect();
        $courseProduct = $db->table('course_products')->where('id', $item['item_id'])->get()->getRowArray();

        // Define duration for course access (in days)
        // Get duration from course_products
        $meta = [
            'duration'      => $courseProduct['duration'] ?? 0, // 0 for unlimited
            'live_batch_id' => $courseProduct['live_batch_id'] ?? 0,
        ];

        $CourseVoucherModel = new \App\Models\CourseVoucherModel();

        try {
            $voucher = $CourseVoucherModel->createVoucher($courseProduct['course_id'], $user, $meta, false); // course_id 1
            if ($voucher['error'] ?? null) {
                log_message('error', $voucher['error']);

                return [
                    'status'  => 'failed',
                    'message' => $voucher['error'],
                ];
            }

            // Kirim email ke user
            $this->data['voucher'] = $voucher['voucher_code'];
            $this->data['course']  = $courseProduct['title'];

            $EmailSender = new \App\Libraries\EmailSender();
            $EmailSender->setTemplate('course_voucher_generated', array_merge($this->data, $user));
            $EmailSender->send($user['email'], 'Pendafaran Kelas ' . $courseProduct['title']);

            return [
                'status'  => 'success',
                'message' => 'Voucher berhasil dibuat',
                'data'    => $voucher ?? [],
            ];
        } catch (Exception $e) {
            log_message('error', $e->getMessage() . "\n" . $e->getFile() . ' on line: ' . $e->getLine());

            return $this->respond([
                'status'  => 'failed',
                'message' => 'Terjadi kesalahan saat membuat voucher',
            ]);
        }
    }
}
