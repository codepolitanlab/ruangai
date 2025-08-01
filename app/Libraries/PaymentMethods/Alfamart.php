<?php

namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class Alfamart extends XenditPaymentMethod
{
    public $name        = 'ALFAMART';
    public $label       = 'Alfamart';
    public $category    = 'Outlet Retail';
    public $description = 'Metode pembayaran menggunakan kode QR standar nasional. <br><br>
	  Anda dapat menggunakan opsi ini untuk melakukan pembayaran menggunakan <strong>Gopay</strong>, <strong>OVO</strong>, serta e-Wallet lain dan juga mobile banking yang telah mendukung QRIS.';
    public $vendor                = 'Xendit';
    public $minNominal            = 1500;
    public $maxNominal            = 5000000;
    public $paymentFee            = 5550;
    public $paymentFeeForCustomer = 5550;
    public $paymentFeeType        = 'fixed';
    public $thumbnail             = '/mobilekit/assets/img/payment-methods/alfamart.png';

    public function __construct()
    {
        parent::__construct();
    }
}
