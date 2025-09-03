<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class UserToken extends Model
{
    protected $table            = 'user_reward_tokens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'code', 'reward_from', 'claimed_at', 'object_id', 'object_type', 'created_at', 'updated_at', 'deleted_at'];

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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function checkTokenUser($user_id, $reward_from, $code = null)
    {
        $query = $this->where('user_id', $user_id)->where('reward_from', $reward_from);

        if ($code) {
            $query->where('code', $code);
        }

        return $query->first();
    }

    public function generateTokenUser($user_id, $reward_from)
    {
        helper('text');

        $code = strtoupper(random_string('alpha', 3)) . $user_id . strtoupper(random_string('alpha', 2));

        return $this->insert([
            'user_id'      => $user_id,
            'code'         => $code,
            'reward_from'  => $reward_from,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    public function generateTokenUserByGraduate($program, $course_id)
    {
        $db = \Config\Database::connect();
        helper('text');

        // Ambil user_id yang lulus tapi belum punya token graduate
        $studentGraduate = $db->table('course_students cs')
            ->select('cs.user_id')
            ->join('scholarship_participants sp', 'sp.user_id = cs.user_id', 'inner')
            ->join('user_reward_tokens urt', 'urt.user_id = cs.user_id AND urt.reward_from = "graduate"', 'left')
            ->where('cs.course_id', $course_id)
            ->where('cs.graduate', 1)
            ->where('sp.program', $program)
            ->where('urt.id IS NULL') // pastikan belum punya token graduate
            ->get()
            ->getResultArray();

        if (!empty($studentGraduate)) {
            // Siapkan data batch untuk insert
            $dataInsert = [];
            foreach ($studentGraduate as $student) {
                $code = strtoupper(random_string('alpha', 3)) . $student['user_id'] . strtoupper(random_string('alpha', 2));
                $dataInsert[] = [
                    'user_id'     => $student['user_id'],
                    'reward_from' => 'graduate',
                    'code'        => $code,
                    'created_at'  => date('Y-m-d H:i:s'),
                ];
            }

            // Insert banyak sekaligus
            $db->table('user_reward_tokens')->insertBatch($dataInsert);
        }


        return [
            'status' => 'success',
            'total_generated' => count($studentGraduate)
        ];
    }

    public function claimToken($user_id, $token_id, $object_id, $object_type)
    {
        return $this->where('id', $token_id)
            ->where('user_id', $user_id)
            ->set([
                'claimed_at'  => date('Y-m-d H:i:s'),
                'object_id'   => $object_id,
                'object_type' => $object_type,
            ])
            ->update();
    }

    public function getAllTokenActive($user_id)
    {
        return $this->where('user_id', $user_id)->where('claimed_at', null)->where('deleted_at', null)->asObject()->findAll();
    }
}
