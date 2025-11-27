<?php

namespace Referral\Models;

use CodeIgniter\Model;

class ReferralModel extends Model
{
    protected $table = 'view_referrals';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [];

    public function getFiltered($filters = [])
    {
        $builder = $this->db->table($this->table)->select('*');

        if (!empty($filters['fullname'])) {
            $builder->like('fullname', $filters['fullname']);
        }

        if (!empty($filters['email'])) {
            $builder->like('email', $filters['email']);
        }

        if (!empty($filters['referral_code'])) {
            $builder->like('referral_code', $filters['referral_code']);
        }

        if (!empty($filters['referrer_graduate_status'])) {
            $builder->where('referrer_graduate_status', $filters['referrer_graduate_status']);
        }

        return $builder;
    }
}
