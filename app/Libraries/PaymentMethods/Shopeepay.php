<?php namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class Shopeepay extends XenditPaymentMethod {

	public $name = "SHOPEEPAY";
	public $label = "E-Wallet ShopeePay";
	public $category = "E-Wallet / QRIS";
	public $description = "Metode pembayaran menggunakan kode QR standar nasional. <br><br>
	  Anda dapat menggunakan opsi ini untuk melakukan pembayaran menggunakan <strong>Gopay</strong>, <strong>OVO</strong>, serta e-Wallet lain dan juga mobile banking yang telah mendukung QRIS.";
	public $vendor = "Xendit";
	public $minNominal = 1500;
	public $maxNominal = 5000000;
	public $paymentFee = 4;
	public $paymentFeeForCustomer = 4.17;
	public $paymentFeeType = "percentage";
	public $thumbnail = "/mobilekit/assets/img/payment-methods/shopeepay.png";

	public function __construct(){
		parent::__construct();
	}

}