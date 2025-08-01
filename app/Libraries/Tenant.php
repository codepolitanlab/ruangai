<?php

namespace App\Libraries;

use Exception;

class Tenant
{
    private $db;
    public $code;
    public $name;
    private $balance;
    private $withdrawn;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function __construct($code)
    {
        $this->db = db_connect();
        $this->_loadTenant($code);
    }

    private function _loadTenant($code)
    {
        $query  = $this->db->table('tenants')->where('code', $code)->get();
        $tenant = $query->getRow();

        if ($tenant) {
            $this->code       = $tenant->code;
            $this->name       = $tenant->name;
            $this->balance    = $tenant->balance;
            $this->withdrawn  = $tenant->withdrawn;
            $this->created_at = $tenant->created_at;
            $this->updated_at = $tenant->updated_at;
            $this->deleted_at = $tenant->deleted_at;
        } else {
            throw new Exception('Tenant not found');
        }
    }

    public function create()
    {
        $this->db->table('tenants')->insert([
            'code'      => $this->code,
            'name'      => $this->name,
            'balance'   => 0.00,
            'withdrawn' => 0.00,
        ]);
    }

    public function addBalance($amount, $transaction_id = null, $note = null)
    {
        $checksum = md5($note);

        // Check if row already exists in log
        $rowExists = $this->db->table('tenant_logs')
            ->where('tenant_code', $this->code)
            ->where('transaction_id', $transaction_id)
            ->where('checksum', $checksum)
            ->get()
            ->getRow();
        if ($rowExists) {
            return false;
        }

        $this->balance += $amount;
        $this->db->table('tenants')->where('code', $this->code)->update(['balance' => $this->balance]);

        $this->db->table('tenant_logs')->insert([
            'tenant_code'    => $this->code,
            'amount'         => $amount,
            'type'           => 'income',
            'transaction_id' => $transaction_id,
            'note'           => $note,
            'checksum'       => $checksum,
        ]);

        return true;
    }

    public function withdraw($amount, $transaction_id = null, $note = null)
    {
        if ($this->balance < $amount) {
            throw new Exception('Insufficient balance');
        }

        $checksum = md5($note);
        // Check if row already exists in log
        $rowExists = $this->db->table('tenant_logs')
            ->where('tenant_code', $this->code)
            ->where('transaction_id', $transaction_id)
            ->where('checksum', $checksum)
            ->get()
            ->getRow();
        if ($rowExists) {
            return false;
        }

        $this->balance -= $amount;
        $this->withdrawn += $amount;

        $this->db->table('tenants')->where('code', $this->code)->update([
            'balance'   => $this->balance,
            'withdrawn' => $this->withdrawn,
        ]);

        $this->db->table('tenant_logs')->insert([
            'tenant_code'    => $this->code,
            'amount'         => -$amount,
            'type'           => 'withdraw',
            'transaction_id' => $transaction_id,
            'note'           => $note,
            'checksum'       => $checksum,
        ]);
    }

    public function syncBalance()
    {
        $query = $this->db->table('tenant_logs')
            ->select('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) AS total_income, SUM(CASE WHEN type = "withdraw" THEN amount ELSE 0 END) AS total_withdrawn')
            ->where('tenant_code', $this->code)
            ->get();

        $result = $query->getRow();

        $this->balance   = $result->total_income - abs($result->total_withdrawn);
        $this->withdrawn = abs($result->total_withdrawn);

        $this->db->table('tenants')->where('code', $this->code)->update([
            'balance'   => $this->balance,
            'withdrawn' => $this->withdrawn,
        ]);
    }
}
