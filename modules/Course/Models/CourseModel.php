<?php

namespace Course\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'partner_id',
        'revenue_sharing',
        'collaborators',
        'course_title',
        'slug',
        'cover',
        'has_modules',
        'has_live_sessions',
        'thumbnail',
        'landing_url',
        'group_whatsapp',
        'description',
        'current_batch_id',
        'tags',
        'premium',
        'status',
        'course_order',
        'last_update',
        'level',
        'bunny_collection_id',
        'created_at',
        'updated_at',
        'total_module',
        'deleted_at',
    ];
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
    protected $afterUpdate    = ['clearCacheCourse'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getTopicLessons($course_id = null)
    {
        $lessonData = $this->db
            ->table('course_lessons')
            ->select('course_lessons.id, course_lessons.lesson_title, course_lessons.status,
                        course_lessons.type, course_lessons.free, course_lessons.course_id, course_lessons.topic_id,
                        course_lessons.lesson_order, course_topics.topic_order')
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
        if ($topicData) {
            foreach ($topicData as $topic) {
                $structured[$topic['id']]            = $topic;
                $structured[$topic['id']]['lessons'] = [];
            }
        }

        if ($lessonData) {
            foreach ($lessonData as $lesson) {
                $structured[$lesson['topic_id']]['lessons'][$lesson['id']] = $lesson;
            }
        }

        return $structured;
    }

    // Set clear cache 'course_'.$id after insert
    public function clearCacheCourse(array $data)
    {
        $courseCacheName = 'course_' . $data['id'][0];
        cache()->delete($courseCacheName);
    }
}
