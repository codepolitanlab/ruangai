<?php

namespace Course\Models;

use CodeIgniter\Model;

class CourseStudentModel extends Model
{
    protected $table                  = 'course_students';
    protected $primaryKey             = 'id';
    protected $useAutoIncrement       = true;
    protected $returnType             = 'array';
    protected $useSoftDeletes         = false;
    protected $protectFields          = true;
    protected $allowedFields          = ['user_id', 'course_id', 'progress', 'graduate', 'created_at', 'updated_at', 'deleted_at'];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    protected array $casts            = [];
    protected array $castHandlers     = [];

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

    public function getLastCertNumber($current_user_id)
    {
        $number = $this->select('cert_number')
            ->where('user_id !=', $current_user_id)
            ->where('cert_number !=', null)
            ->orderBy('cert_number', 'desc')
            ->get()
            ->getRowArray();

        return $number['cert_number'] ?? 0;
    }

    public function getUserCourses($user_id)
    {
        return $this->where('user_id', $user_id)->get()->getResult();
    }

    public function enrollStudent($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    // di CourseStudentModel.php
    public function getStudent($userId, $courseId)
    {
        return $this->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();
    }

    public function markAsGraduate($userId, $courseId)
    {
        // Generate user token for graduate if not exists
        $userTokenModel = model('UserToken');
        $isExist = $userTokenModel->isExists($userId, 'graduate');
        if (! $isExist) {
            $userTokenModel->generate($userId, 'graduate');
        }

        return $this->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->set(['graduate' => 1])
            ->update();
    }

    public function markAsNotGraduate($userId, $courseId)
    {
        return $this->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->set(['graduate' => 0])
            ->update();
    }
}
