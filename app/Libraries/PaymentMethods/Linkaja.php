<?php namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class Linkaja extends XenditPaymentMethod {

	public $name = "LINKAJA";
	public $label = "E-Wallet LinkAja";
	public $category = "E-Wallet / QRIS";
	public $description = "Metode pembayaran menggunakan kode QR standar nasional. <br><br>
	  Anda dapat menggunakan opsi ini untuk melakukan pembayaran menggunakan <strong>Gopay</strong>, <strong>OVO</strong>, serta e-Wallet lain dan juga mobile banking yang telah mendukung QRIS.";
	public $vendor = "Xendit";
	public $minNominal = 1500;
	public $maxNominal = 5000000;
	public $paymentFee = 3;
	public $paymentFeeForCustomer = 3.1;
	public $paymentFeeType = "percentage";
	public $thumbnail = "/mobilekit/assets/img/payment-methods/linkaja2.png";

	public function __construct(){
		parent::__construct();
	}

}