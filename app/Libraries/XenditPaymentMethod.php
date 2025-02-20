<?php namespace App\Libraries;

use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;

/**
 * Payment Method
 *
 * Payment method base class
 *
 * @author Toni
 * @package Payment
 * @copyright 2021
 */
abstract class XenditPaymentMethod extends BasePaymentMethod {

	public $name;
	public $paymentTemplate = "xeninvoice";
	
	protected $secretKey;
	protected $callbackToken;

	public function __construct(){
		parent::__construct();

		$this->secretKey = config('Heroic')->xenditSecretKey;
		$this->callbackToken =  config('Heroic')->xenditCallbackToken;
	}

	public function commit($order)
	{
		$paydata = [
			'external_id'           => $order['order_code'],
			'description'			=> $order['description'] ?? '',
			'amount'                => $order['total'],
			'success_redirect_url'  => $order['success_redirect_url'] ?? null,
			'failure_redirect_url'  => $order['failure_redirect_url'] ?? null,
			'payment_methods'		=> [$this->name],
			'locale'				=> "id",
			'currency' 				=> 'IDR',
			'invoice_duration' 		=> 60*60*3, // 3 hours
		];

		Configuration::setXenditKey($this->secretKey);
		$apiInstance = new InvoiceApi();
		$create_invoice_request = new \Xendit\Invoice\CreateInvoiceRequest($paydata);

		try {
			$result = $apiInstance->createInvoice($create_invoice_request);
		} catch (\Xendit\XenditSdkException $e) {
			echo 'Exception when calling InvoiceApi->createInvoice: ', $e->getMessage(), PHP_EOL;
			echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
			die;
		}

		return $result;
	}

	public function get($transactionData)
	{
		return $transactionData;
	}

}