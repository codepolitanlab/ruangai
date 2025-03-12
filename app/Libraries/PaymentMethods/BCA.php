<?php namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class BCA extends XenditPaymentMethod {

	public $name = "BCA";
	public $label = "Transfer VA BCA";
	public $category = "Transfer Virtual Account (VA)";
	public $description = "Metode pembayaran menggunakan kode QR standar nasional. <br><br>
	  Anda dapat menggunakan opsi ini untuk melakukan pembayaran menggunakan <strong>Gopay</strong>, <strong>OVO</strong>, serta e-Wallet lain dan juga mobile banking yang telah mendukung QRIS.";
	public $vendor = "Xendit";
	public $minNominal = 10000;
	public $maxNominal = 5000000;
	public $paymentFee = 4440;
	public $paymentFeeForCustomer = 4440;
	public $paymentFeeType = "fixed";
	public $thumbnail = "/mobilekit/assets/img/payment-methods/bca.png";

	public function __construct(){
		parent::__construct();
	}

}