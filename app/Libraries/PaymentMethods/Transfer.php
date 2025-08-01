<?php

namespace App\Libraries\PaymentMethods;

use App\Libraries\BasePaymentMethod;
use App\Libraries\CartConveyor;

class Transfer extends BasePaymentMethod
{
    public $name        = 'Transfer';
    public $label       = 'Transfer Manual';
    public $category    = 'Transfer Manual';
    public $description = 'Transfer manual. <br><br>
	  Sistem akan mengurangi nominal sejumlah 3 digit acak antara 500 dan 999
	  dari biaya administrasi untuk kebutuhan verifikasi transfer.';
    public $vendor                = 'Heroicbit';
    public $minNominal            = 10000;
    public $maxNominal            = 5000000;
    public $paymentFee            = 1000;
    public $paymentFeeForCustomer = 1000;
    public $paymentFeeType        = 'fixed';
    public $thumbnail             = '/mobilekit/assets/img/payment-methods/transfer.svg';

    public function __construct()
    {
        parent::__construct();
    }

    // public function confirm()
    // {
    // 	$fields = [
    // 		'paid_by' => [
    // 			'field' => 'paid_by',
    // 			'label' => 'Dibayar oleh',
    // 			'placeholder' => 'Nama pembayar',
    // 			'form' => 'text',
    // 			'rules' => 'required'
    // 		],
    // 		'phone' => [
    // 			'field' => 'phone',
    // 			'label' => 'No.Telepon',
    // 			'form' => 'whatsapp',
    // 			'placeholder' => 'No.Telepon',
    // 			'rules' => 'required|numeric'
    // 		],
    // 		'email' => [
    // 			'field' => 'email',
    // 			'label' => 'Email',
    // 			'form' => 'email',
    // 			'placeholder' => 'Email',
    // 			'rules' => 'valid_email|min_length[20]'
    // 		],
    // 		'received_by' => [
    // 			'field' => 'received_by',
    // 			'label' => 'Diterima oleh',
    // 			'placeholder' => 'Nama admin penerima',
    // 			'form' => 'text',
    // 			'rules' => 'required'
    // 		]
    // 	];

    // 	$CartConveyor = new CartConveyor();
    // 	$total = $CartConveyor->getAttributeTotal();
    // 	$staticPaymentFee = setting_item('payment.static_transaction_fee') ?? 0;
    // 	$tax = setting_item('payment.calculate_tax') == 'yes' ? ($total + $staticPaymentFee) * 10 / 100 : 0;

    // 	if ($total <= 0) redirect(getenv('HTTP_REFERER'));

    // 	$data['paid_by'] = ci()->input->post('paid_by', true);
    // 	$data['phone'] = ci()->input->post('phone', true);
    // 	$data['email'] = ci()->input->post('email', true);
    // 	$data['received_by'] = ci()->input->post('received_by', true);

    // 	// PROCESS POSTDATA and return status=true if valid
    // 	ci()->load->library('form_validation');
    // 	ci()->form_validation->set_rules($fields);
    // 	if (ci()->form_validation->run() == FALSE) {
    // 		$error_message = validation_errors() ? '<div class="alert alert-warning mb-3">' . validation_errors() . '</div>' : '';
    // 	} else {
    // 		$CartConveyor->setCustomer($data['paid_by'], $data['email'], $data['phone'], ['received_by' => $data['received_by']]);
    // 		$status = true;
    // 		return compact('data', 'status');
    // 	}

    // 	// Generate form
    // 	$form = '<div class="form-group mb-2">' .
    // 	'<div class="bg-white p-2 mb-3 rounded-2 shadow-sm">' .
    // 	'<label>Nominal: Rp ' . number_format($total, 0, ',', '.') . '</label>' .
    // 	($staticPaymentFee ? '<br><label>Biaya admin: Rp ' . number_format($staticPaymentFee, 0, ',', '.') . '</label>' : '') .
    // 	($tax ? '<br><label>Pajak 10%: Rp ' . number_format($tax, 0, ',', '.') . '</label>' : '') .
    // 	'<br><label class="text-success">Total Dibayarkan: Rp ' . number_format($total + $tax + $staticPaymentFee, 0, ',', '.') . '</label>' .
    // 	'</div>' .
    // 	'<div class="form-group mb-2">' .
    // 	'<label>Dibayarkan oleh</label>' .
    // 	'<div class="row">' .
    // 	'<div class="col-sm-4 mb-1">' .
    // 	generate_input($fields['paid_by'], $data['paid_by'] ?? '') .
    // 	'</div>' .
    // 	'<div class="col-sm-4 mb-1">' .
    // 	generate_input($fields['phone'], $data['phone'] ?? '') .
    // 	'</div>' .
    // 	'<div class="col-sm-4 mb-1">' .
    // 	generate_input($fields['email'], $data['email'] ?? '') .
    // 	'</div>' .
    // 	'</div>' .
    // 	'</div>' .
    // 	'<div class="form-group mb-2">' .
    // 	'<label>Diterima oleh</label>' .
    // 	generate_input($fields['received_by'], $data['received_by'] ?? '') .
    // 	'</div>' .
    // 	'</div>';

    // 	return compact('data', 'form', 'error_message');
    // }

    public function get($transactionData)
    {
        return $transactionData;
    }

    public function commit($order)
    {
        $order['amount']               = $order['total'];
        $order['pending_redirect_url'] = site_url('payment/pay/pending/' . $order['order_code']);

        return $order;
    }

    public function pending($finishData)
    {
        $finishData['title']       = 'Pembayaran Berhasil Dicatat';
        $finishData['description'] = '';
        $finishData['buttons']     = [
            '<div class="d-flex justify-content-center">',
            '<a href="' . site_url('admin/tagihan') . '" class="btn btn-outline-secondary me-2"><span class="bi bi-arrow-left me-2"></span> Kembali</a>',
            '<a target="_blank" href="' . site_url('payment/receipt/index/' . $finishData['Transaction']->order_code) . '" class="btn btn-outline-primary"><span class="bi bi-receipt me-2"></span> Lihat Bukti Pembayaran</a>',
            '</div>',
        ];

        return $finishData;
    }
}
