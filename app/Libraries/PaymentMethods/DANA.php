<?php namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class DANA extends XenditPaymentMethod {

	public $name = "DANA";
	public $label = "E-wallet DANA";
	public $category = "E-Wallet / QRIS";
	public $description = "Metode pembayaran menggunakan kode QR standar nasional. <br><br>
	  Anda dapat menggunakan opsi ini untuk melakukan pembayaran menggunakan <strong>Gopay</strong>, <strong>OVO</strong>, serta e-Wallet lain dan juga mobile banking yang telah mendukung QRIS.";
	public $vendor = "Xendit";
	public $minNominal = 1500;
	public $maxNominal = 5000000;
	public $paymentFee = 1.665;
	public $paymentFeeForCustomer = 1.7;
	public $paymentFeeType = "percentage";
	public $thumbnail = "/mobilekit/assets/img/payment-methods/dana.png";

	public function __construct(){
		parent::__construct();
	}

}