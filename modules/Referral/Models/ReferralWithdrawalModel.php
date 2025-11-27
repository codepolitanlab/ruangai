<?php

namespace Referral\Models;

use CodeIgniter\Model;

class ReferralWithdrawalModel extends Model
{
    protected $table = 'referral_withdrawal';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'amount', 'withdrawn_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $useSoftDeletes = true;
    protected $returnType = 'array';

    public function getFiltered($filters = [])
    {
        $builder = $this->db->table($this->table)->select('referral_withdrawal.*, users.name, users.email')
            ->join('users', 'users.id = referral_withdrawal.user_id', 'left');

        if (!empty($filters['user'])) {
            $builder->groupStart()
                ->like('users.name', $filters['user'])
                ->orLike('users.email', $filters['user'])
                ->groupEnd();
        }

        if (!empty($filters['amount'])) {
            $builder->where('amount', $filters['amount']);
        }

        if (!empty($filters['created_at'])) {
            $builder->where('DATE(created_at)', $filters['created_at']);
        }

        if (!empty($filters['withdrawn_at'])) {
            $builder->where('DATE(withdrawn_at)', $filters['withdrawn_at']);
        }

        return $builder;
    }

    public function recalculateUserBalance($userId)
    {
        // Calculate total commissions earned by the user
        $db = \Config\Database::connect();

        // Calculate total withdrawn amount by the user
        $totalWithdrawnRow = $db->table('referral_withdrawal')
            ->select('SUM(amount) as total_withdrawn')
            ->where('user_id', $userId)
            ->get()
            ->getRowArray();
        $totalWithdrawn = isset($totalWithdrawnRow['total_withdrawn']) ? (float)$totalWithdrawnRow['total_withdrawn'] : 0.0;

        // Update scholarships_participants.withdrawal with total withdrawn amount
        $db->table('scholarship_participants')
            ->where('user_id', $userId)
            ->update(['withdrawal' => $totalWithdrawn]);
    }
}
