<?php

namespace App\Libraries\PaymentMethods;

use App\Libraries\BasePaymentMethod;
use Package\Commerce\modules\payment\models\Transaction;

class Voucher extends BasePaymentMethod
{
    public $name                  = 'Voucher';
    public $label                 = 'Voucher';
    public $category              = 'Voucher';
    public $description           = 'Redeem produk dengan voucher';
    public $vendor                = 'Heroicbit';
    public $minNominal            = 1000;
    public $maxNominal            = 500000000;
    public $paymentFee            = 0;
    public $paymentFeeForCustomer = 0;
    public $paymentFeeType        = 'fixed';
    public $permission            = 'pay_with_voucher';
    public $thumbnail             = '/mobilekit/assets/img/payment-methods/voucher.png';

    public function commit($order)
    {
        return [
            'external_id'          => $order['order_code'],
            'amount'               => 0,
            'success_redirect_url' => $order['success_redirect_url'],
            'failure_redirect_url' => $order['failure_redirect_url'],
        ];
    }

    public function get($payment_id)
    {
    }

    public function onSettled(Transaction $order)
    {
        $VoucherModel = setup_entry_model('voucher');
        $VoucherModel->where('voucher_code', $order->coupon_code)->update([
            'is_redeemed' => 1,
            'redeemed_at' => date('Y-m-d H:i:s'),
            'redeemed_by' => $order->user['id'],
        ]);
    }
}
