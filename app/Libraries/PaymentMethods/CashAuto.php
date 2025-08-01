<?php

namespace App\Libraries\PaymentMethods;

use App\Libraries\BasePaymentMethod;
use App\Libraries\CartConveyor;

class CashAuto extends BasePaymentMethod
{
    public $name                  = 'Cash';
    public $label                 = 'Cash Auto';
    public $category              = 'Tunai';
    public $description           = 'Pembayaran langsung tunai dikonfirmasi oleh Admin.';
    public $vendor                = 'Heroicbit';
    public $minNominal            = 1000;
    public $maxNominal            = 500000000;
    public $paymentFee            = 0;
    public $paymentFeeForCustomer = 0;
    public $paymentFeeType        = 'fixed';
    public $permission            = 'pay_with_cash';
    public $paymentTemplate       = 'cash';
    public $thumbnail             = '/mobilekit/assets/img/payment-methods/tunai.png';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Supply confirmation form before
     *
     * @param mixed $finishData
     *
     * @return array $data, $status, form, error_message
     */
    // public function confirm()
    // {
    // 	$CartConveyor = new CartConveyor();
    // 	$total = $CartConveyor->getAttributeTotal();
    // 	$totalItem = count($CartConveyor->getItems());
    // 	$staticPaymentFee = setting_item('payment.static_transaction_fee') ?? 0;
    // 	$tax = setting_item('payment.calculate_tax') == 'yes' ? ($total+$staticPaymentFee)*10/100 : 0;

    // 	if ($total <= 0) redirect(getenv('HTTP_REFERER'));
    // 	$user = ci()->shared['me'];

    // 	$data['paid_by'] = $user['name'];
    // 	$data['user_id'] = $user['user_id'];
    // 	$data['phone'] = $user['phone'];
    // 	$data['email'] = $user['email'];
    // 	$data['received_by'] = ci()->input->post('received_by', true);

    // 	// PROCESS POSTDATA confirmation
    // 	if (ci()->input->post()) {
    // 		$CartConveyor->setCustomer($data['paid_by'], $data['email'], $data['phone'], ['received_by' => $data['received_by']]);
    // 		$status = true;
    // 		return compact('data', 'status');
    // 	}

    // 	// Generate form
    // 	$form = '<div class="form-group mb-2">'.
    // 				'<table class="table table-sm table-hover shadow-sm table-responsive">'.
    // 				'<tr><td>Disetorkan oleh: </td><td class="text-end">'. $data['paid_by']. '<br>' . $data['email'] .'<br>'. $data['phone'] .'</td></tr>'.
    // 				'<tr><td>Total item: </td><td class="text-end">'. $totalItem .'</td></tr>'.
    // 					'<tr><td>Nominal: </td><td class="text-end">Rp '. number_format($total,0,',','.') .'</td></tr>'.
    // 					($staticPaymentFee ? '<tr><td>Biaya admin: </td><td class="text-end">Rp '. number_format($staticPaymentFee,0,',','.') .'</td></tr>' : '').
    // 					($tax ? '<tr><td>Pajak 10%: </td><td class="text-end">Rp '. number_format($tax, 0, ',', '.') .'</td></tr>' : '').
    // 					'<tr><td class="text-primary fs-6">Total Dibayarkan: </td><td class="text-primary text-end"><strong>Rp '. number_format($total + $tax + $staticPaymentFee,0,',','.') .'</strong></td></tr>'.
    // 				'</table>'.
    // 				'<input type="hidden" name="paid_by" value="'.$data['paid_by'].'">'.
    // 				'<input type="hidden" name="user_id" value="'.$data['user_id'].'">'.
    // 				'<input type="hidden" name="email" value="'.$data['email'].'">'.
    // 				'<input type="hidden" name="phone" value="'.$data['phone'].'">'.
    // 				'<p class="my-3">Silakan menyerahkan nominal sejumlah <strong class="text-nowrap fw-bold">Rp '. number_format($total + $tax + $staticPaymentFee,0,',','.') .'</strong> ke Admin dan tekan tombol Konfirmasi untuk menyelesaikan pembayaran.</p>'.
    // 			'</div>';

    // 	return compact('data', 'form');
    // }

    // public function commit($order)
    // {
    // 	$order['amount'] = $order['total'];
    // 	$order['success_redirect_url'] = site_url('payment/pay/finish/'.$order['order_code']);

    // 	return $order;
    // }

    public function finish($finishData)
    {
        $finishData['title']       = 'Pembayaran berhasil dicatat';
        $finishData['description'] = '';
        $finishData['buttons']     = [
            '<div class="d-flex justify-content-center">',
            '<a href="' . site_url('admin/tagihan') . '" class="btn btn-outline-secondary me-2"><span class="bi bi-arrow-left me-2"></span> Kembali</a><br>',
            '<a target="_blank" href="' . site_url('payment/receipt/index/' . $finishData['Transaction']->order_code) . '" class="btn btn-outline-primary"><span class="bi bi-receipt me-2"></span> Lihat Invoice</a>',
            '</div>',
        ];

        return $finishData;
    }
}
