<?php

namespace App\Models;

use CodeIgniter\Model;

class Checkout extends Model
{
    protected $table            = 'checkouts';
    protected $primaryKey       = 'code';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['tenant_id','user_id','guest_name','guest_contact','guest_address','description','items','item_amount','payment_method','payment_fee'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['prepareCheckoutData'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Prepare checkout data before save to database.
     *
     * @param array $data Checkout data
     *
     * @return array Checkout data with code, items as json, and total
     */
    protected function prepareCheckoutData(array $data)
    {
        // Generate checkout code
        $charset = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $tenantCode = $data['data']['tenant_id'] ?? substr(str_shuffle($charset), 0, 4);
        $dateCode = strtoupper(dechex(intval(date('ymd'))));
        $randomChars = substr(str_shuffle($charset), 0, 4);
        $data['data']['code'] = "{$tenantCode}-{$dateCode}{$randomChars}";

        // Convert items to json
        if(is_array($data['data']['items']))
            $data['data']['items'] = json_encode($data['data']['items']);

        // Count total
        $data['data']['total'] = $data['data']['item_amount'] + $data['data']['payment_fee'];

        return $data;
    }

    public function updateStatus($code, $status)
    {
        $db = \Config\Database::connect();
        $db->table($this->table)
            ->where('code', $code)
            ->update([
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}
