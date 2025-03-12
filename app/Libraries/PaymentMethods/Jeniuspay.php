<?php namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class Jeniuspay extends XenditPaymentMethod {

	public $name = "JENIUSPAY";
	public $label = "E-Wallet JeniusPay";
	public $category = "E-Wallet / QRIS";
	public $description = "Metode pembayaran menggunakan kode QR standar nasional. <br><br>
	  Anda dapat menggunakan opsi ini untuk melakukan pembayaran menggunakan <strong>Gopay</strong>, <strong>OVO</strong>, serta e-Wallet lain dan juga mobile banking yang telah mendukung QRIS.";
	public $vendor = "Xendit";
	public $minNominal = 1500;
	public $maxNominal = 5000000;
	public $paymentFee = 2.22;
	public $paymentFeeForCustomer = 2.28;
	public $paymentFeeType = "percentage";	
	public $thumbnail = "/mobilekit/assets/img/payment-methods/jeniuspay.png";

	public function __construct(){
		parent::__construct();
	}

}