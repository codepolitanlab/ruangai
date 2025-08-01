<?php

namespace App\Libraries;

/**
 * Payment Method
 *
 * Payment method base class
 *
 * @copyright 2021
 */
class BasePaymentMethod
{
    public $name;
    public $description;
    public $vendor;
    public $minNominal;
    public $maxNominal;
    public $paymentFee;
    public $paymentFeeForCustomer;
    public $paymentFeeType;
    public $thumbnail;
    protected $endpoint;

    public function __construct()
    {
    }

    public function get($transactionData)
    {
        return $transactionData;
    }

    public function getPaymentFee($item_amount)
    {
        return ($this->paymentFeeType === 'fixed')
            ? $this->paymentFeeForCustomer
            : round(($this->paymentFeeForCustomer / 100) * $item_amount);
    }

    /**
     * Supply form and process postdata before commit transaction
     *
     * Must return array with status=true to continue transaction
     *
     * @return array
     */
    public function confirm()
    {
        return ['status' => true];
    }

    // Run when payment is commiting
    // Must be overrided with real payment process
    public function commit($order)
    {
        $order['payment_id']   = random_string();
        $order['callback_url'] = 'https://webhook.site';
        $order['amount']       = $order['total'];

        return $order;
    }

    // Run when order status set to pending
    public function onPending(Transaction $order)
    {
        ci()->event->trigger('payment.onPending', $order);

        // Send email
        $mailer          = new \App\libraries\Emailer();
        $mailer->to      = [$order->customer_email, $order->customer_name];
        $mailer->subject = setting_item('site.site_title') . ' - Konfirmasi Pemesanan';
        $mailer->body    = ci()->load->view('payment/email/order-confirmation', compact('order'), true);
        $mailer->send();
    }

    // Run when order status set to canceled (before settle)
    public function onCanceled(Transaction $order)
    {
        ci()->event->trigger('payment.onCanceled', $order);
    }

    // Run when order status set to expired
    public function onExpired(Transaction $order)
    {
        ci()->event->trigger('payment.onExpired', $order);
    }

    // Run when order status set to refund (means it has settled or on process)
    public function onRefund(Transaction $order)
    {
        ci()->event->trigger('payment.onRefund', $order);
    }

    // Run when order status set to settled
    public function onSettled(Transaction $order)
    {
        ci()->event->trigger('payment.onSettled', $order);

        // Updating Voucher, MUST BE INCLUDED if overrided
        if ($voucher_id = $order->voucher_id) {
            $VoucherModel = setup_entry_model('voucher');
            $VoucherModel->where('id', $voucher_id)->update([
                'is_redeemed' => 1,
                'redeemed_at' => date('Y-m-d H:i:s'),
                'redeemed_by' => $order->id,
            ]);
        }

        // Send email pembayaran diterima
        ci()->load->helper('email');
        sendEmail(
            [$order->user['email'], $order->user['name']],
            setting_item('site.site_title') . ' - Pembayaran Diterima',
            compact('order'),
            PACKAGEPATH . 'Commerce/modules/payment/views/email/order-paid.php'
        );
    }

    public function onCapture(Transaction $order)
    {
        ci()->event->trigger('payment.onCapture', $order);
    }

    // Run when order status set to process
    public function onProcessing(Transaction $order)
    {
        ci()->event->trigger('payment.onProcessing', $order);
    }

    // Run when order status set to shipped
    public function onShipped(Transaction $order)
    {
        ci()->event->trigger('payment.onShipped', $order);

        // Send email
        $mailer          = new \App\libraries\Emailer();
        $mailer->to      = [$order->user['email'], $order->user['name']];
        $mailer->subject = setting_item('site.site_title') . ' - Produk Sedang Dikirim';
        $mailer->body    = ci()->load->view('payment/email/order-shipping', compact('order'), true);
        $mailer->send();
    }

    // Run when order status set to done
    public function onDone(Transaction $order)
    {
        ci()->event->trigger('payment.onDone', $order);
    }
}
