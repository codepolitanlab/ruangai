<?php

namespace App\Pages\webhook;

use App\Libraries\Transaction;
use App\Pages\BaseController;

class PageController extends BaseController
{

    public function getIndex()
    {
        return $this->respond('Unauthorized', 401);
    }

    public function postIndex($token = null)
    {
        if(strcmp($_SERVER['HTTP_X_CALLBACK_TOKEN'] ?? null, config('App')->xenditCallbackToken) !== 0) {
            return $this->respond('Unauthorized', 401);
        }

        // Handle Xendit callback
        $payload = file_get_contents('php://input');
        $invoice_callback = json_decode($payload, true);
        $this->logWebhook($invoice_callback['external_id'], $payload);

        // Handle paid invoice
        if($invoice_callback['status'] == 'PAID') 
        {    
            // Insert to transaction
            $Transaction = new Transaction();
            $Transaction->assignWebhookPayload($invoice_callback);
            $Transaction->save();

            // Update checkout status
            model('Checkout')->updateStatus($Transaction->code, 'paid');

            // TODO: Send whatsapp to member

            // TODO: Send email to member

        }
    }

    private function logWebhook($code, $payload)
    {
        $db = \Config\Database::connect();
        $db->table('transaction_webhook_logs')->insert([
            'code' => $code,
            'payload' => $payload,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    } 

    public function getTest()
    {
        $TenantPC = new \App\Libraries\Tenant('PC.26');
        $TenantPC->syncBalance();
        $TenantPD = new \App\Libraries\Tenant('PD-26');
        $TenantPD->syncBalance();
        $TenantPW = new \App\Libraries\Tenant('PW-1');
        $TenantPW->syncBalance();
        $TenantPP = new \App\Libraries\Tenant('PP');
        $TenantPP->syncBalance();
        dd($TenantPC, $TenantPD, $TenantPW, $TenantPP);
    }

}

