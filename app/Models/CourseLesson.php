<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseLesson extends Model
{
    protected $table                  = 'course_lessons';
    protected $primaryKey             = 'id';
    protected $useAutoIncrement       = true;
    protected $returnType             = 'array';
    protected $useSoftDeletes         = true;
    protected $protectFields          = true;
    protected $allowedFields          = ['course_id', 'topic_id', 'lesson_title', 'lesson_order', 'lesson_slug', 'text', 'quiz', 'type', 'status', 'free', 'mandatory', 'video_diupload', 'video_bunny', 'duration'];
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

    public function syncSequence()
    {
        $this->db->query("SELECT setval('course_lessons_id_seq', (SELECT MAX(id) FROM course_lessons));");
    }
}
