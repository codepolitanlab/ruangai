<?php

namespace App\Libraries\ProductTypes;

use App\Libraries\Transaction;

class BillProductType
{
    protected $table = 'md_bills';

    public $id;
    public $title;
    public $description;
    public $amount;
    public $npa;
    public $name;
    public $kd_pc;
    public $kd_pd; 
    public $kd_pw; 

    public function __construct($id) 
    {
        $db = \Config\Database::connect();
        $bill = $db->table($this->table)
                    ->select('md_bills.id, title, description, amount, mein_users.name, anggota.npa, anggota.kd_pc, anggota.kd_pd, anggota.kd_pw')
                    ->join('mein_users', 'mein_users.id = md_bills.user_id')
                    ->join('anggota', 'anggota.npa = mein_users.username')
                    ->where('md_bills.id', $id)
                    ->get()
                    ->getRow();

        if(!$bill) {
            throw new \Exception('Bill not found', 404);
        }

        $this->id = $bill->id;
        $this->title = $bill->title;
        $this->description = $bill->description;
        $this->amount = $bill->amount;
        $this->npa = $bill->npa;
        $this->name = $bill->name;
        $this->kd_pc = $bill->kd_pc;
        $this->kd_pd = $bill->kd_pd;
        $this->kd_pw = $bill->kd_pw; 
    }
    
    public function onPaid(Transaction $Transaction) 
    {
        $db = \Config\Database::connect();

        // Update bill product status to paid
        $db->table($this->table)
            ->where('id', $this->id)
            ->update([
                'status' => 'paid',
                'transaction_id' => $Transaction->id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        // Divide bill to tenants' wallet
        // Tenant portion
        $porsiPC = 0.5;
        $porsiPD = 0.2;
        $porsiPW = 0.15;
        $porsiPP = 0.15;

        $logTitle = $this->title.' - '.$this->name . ' (' . $this->npa .')';

        // Divide to PC
        $TenantPC = new \App\Libraries\Tenant($this->kd_pc);
        $TenantPC->addBalance($this->amount * $porsiPC, $Transaction->id, $logTitle);
        
        // Divide to PD
        $TenantPD = new \App\Libraries\Tenant($this->kd_pd);
        $TenantPD->addBalance($this->amount * $porsiPD, $Transaction->id, $logTitle);
        
        // Divide to PW
        $TenantPW = new \App\Libraries\Tenant($this->kd_pw);
        $TenantPW->addBalance($this->amount * $porsiPW, $Transaction->id, $logTitle);
        
        // Divide to PP
        $TenantPP = new \App\Libraries\Tenant('PP');
        $TenantPP->addBalance($this->amount * $porsiPP, $Transaction->id, $logTitle);
    }

    public function onRefund(Transaction $Transaction) 
    {
        $db = \Config\Database::connect();
        $db->table($this->table)
            ->where('id', $this->id)
            ->update([
                'status' => 'pending',
                'transaction_id' => null,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}