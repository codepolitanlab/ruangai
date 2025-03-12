<?php namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class CIMB extends XenditPaymentMethod {

	public $name = "CIMB";
	public $label = "Transfer VA CIMB";
	public $category = "Transfer Virtual Account (VA)";
	public $description = "Metode pembayaran menggunakan virtual account bank CIMB";
	public $vendor = "Xendit";
	public $minNominal = 10000;
	public $maxNominal = 5000000;
	public $paymentFee = 4440;
	public $paymentFeeForCustomer = 4440;
	public $paymentFeeType = "fixed";
	public $thumbnail = "/mobilekit/assets/img/payment-methods/cimb.png";

	public function __construct(){
		parent::__construct();
	}

}