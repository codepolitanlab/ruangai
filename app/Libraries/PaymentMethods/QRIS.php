<?php namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class QRIS extends XenditPaymentMethod {

	public $name = "QRIS";
	public $label = "QRIS";
	public $category = "E-Wallet / QRIS";
	public $description = "Metode pembayaran menggunakan kode QR standar nasional. <br><br>
	  Anda dapat menggunakan opsi ini untuk melakukan pembayaran menggunakan <strong>Gopay</strong>, <strong>OVO</strong>, serta e-Wallet lain dan juga mobile banking yang telah mendukung QRIS.";
	public $vendor = "Xendit";
	public $minNominal = 100;
	public $maxNominal = 5000000;
	public $paymentFee = 0.7;
	public $paymentFeeForCustomer = 0.71;
	public $paymentFeeType = "percentage";
	public $thumbnail = "/mobilekit/assets/img/payment-methods/qris.png";

	public function __construct(){
		parent::__construct();
	}

}