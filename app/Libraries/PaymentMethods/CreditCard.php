<?php namespace App\Libraries\PaymentMethods;

use App\Libraries\XenditPaymentMethod;

class CreditCard extends XenditPaymentMethod {

	public $name = "CREDIT_CARD";
	public $label = "Kartu Kredit/Debit";
	public $category = "Credit / Debit Card";
	public $description = "Metode pembayaran menggunakan kode QR standar nasional. <br><br>
	  Anda dapat menggunakan opsi ini untuk melakukan pembayaran menggunakan <strong>Gopay</strong>, <strong>OVO</strong>, serta e-Wallet lain dan juga mobile banking yang telah mendukung QRIS.";
	public $vendor = "Xendit";
	public $minNominal = 10000;
	public $maxNominal = 5000000;
	public $paymentFee = 2.9;
	public $paymentFeeForCustomer = 2.99;
	public $paymentFeeType = "percentage";
	public $thumbnail = "/mobilekit/assets/img/payment-methods/cc.png";

	public function __construct(){
		parent::__construct();
	}

}