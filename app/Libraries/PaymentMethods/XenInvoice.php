<?php

namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class XenInvoice extends XenditPaymentMethod
{
    public $name           = 'XenInvoice';
    public $description    = 'Kanal pembayaran menggunakan antarmuka Xendit dengan beragam metode pembayaran.';
    public $vendor         = 'Xendit';
    public $minNominal     = 1500;
    public $maxNominal     = 5000000;
    public $paymentFee     = 0;
    public $paymentFeeType = 'fixed';
    public $className      = "Package\\Commerce\\modules\\payment\\methods\xeninvoice\\XenInvoice";
    public $thumbnail      = 'views/theme/assets/images/payment-methods/transfer.png';

    public function __construct()
    {
        parent::__construct();
    }
}
