<?php

namespace Course\Models;

use CodeIgniter\Model;

class CourseTopicModel extends Model
{
    protected $table                  = 'course_topics';
    protected $primaryKey             = 'id';
    protected $useAutoIncrement       = true;
    protected $returnType             = 'array';
    protected $useSoftDeletes         = true;
    protected $protectFields          = true;
    protected $allowedFields          = ['course_id', 'topic_title', 'topic_slug', 'topic_order', 'free', 'status'];
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

    public function hasLessons($topic_id)
    {
        return $this->db->table('course_lessons')
            ->where('topic_id', $topic_id)
            ->where('deleted_at', null)
            ->countAllResults();
    }
}
