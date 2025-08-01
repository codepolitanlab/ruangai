<?php

namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class BCAKlikpay extends XenditPaymentMethod
{
    public $name        = 'DD_BCA_KLIKPAY';
    public $label       = 'BCA Klikpay';
    public $category    = 'Direct Debit';
    public $description = 'Metode pembayaran menggunakan kode QR standar nasional. <br><br>
	  Anda dapat menggunakan opsi ini untuk melakukan pembayaran menggunakan <strong>Gopay</strong>, <strong>OVO</strong>, serta e-Wallet lain dan juga mobile banking yang telah mendukung QRIS.';
    public $vendor                = 'Xendit';
    public $minNominal            = 1500;
    public $maxNominal            = 5000000;
    public $paymentFee            = 4440;
    public $paymentFeeForCustomer = 4440;
    public $paymentFeeType        = 'fixed';
    public $thumbnail             = '/mobilekit/assets/img/payment-methods/dd_bca_klikpay.png';

    public function __construct()
    {
        parent::__construct();
    }
}
