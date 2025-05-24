<?php

namespace App\Models;

use CodeIgniter\Model;

class Course extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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

    public function getTopicLessons($course_id = null)
    {
        $lessonData = $this->db
                        ->table('course_lessons')
                        ->select('course_lessons.*, course_topics.topic_order')
                        ->join('course_topics', 'course_topics.id = course_lessons.topic_id')
                        ->where('course_lessons.course_id', $course_id)
                        ->where('course_lessons.deleted_at', null)
                        ->orderBy('course_topics.topic_order', 'ASC')
                        ->orderBy('course_lessons.lesson_order', 'ASC')
                        ->get()
                        ->getResultArray();

        $topicData = $this->db
                        ->table('course_topics')
                        ->where('course_id', $course_id)
                        ->where('deleted_at', null)
                        ->orderBy('topic_order', 'ASC')
                        ->get()
                        ->getResultArray();

        $structured = [];
        if($topicData) {
            foreach ($topicData as $topic) {
                $structured[$topic['id']] = $topic;
                $structured[$topic['id']]['lessons'] = [];
            }
        }
        
        if($lessonData) {
            foreach ($lessonData as $lesson) {
                $structured[$lesson['topic_id']]['lessons'][$lesson['id']] = $lesson;
            }
        }

        return $structured;
    }
}
