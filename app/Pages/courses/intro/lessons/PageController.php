<?php

namespace App\Pages\courses\intro\lessons;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Daftar Materi',
        'module'      => 'course_lesson',
        'active_page' => 'materi',
    ];

    public function getData($id)
    {
        $db = \Config\Database::connect();
        $course = $db->table('courses')
            ->where('courses.id', $id)
            ->groupBy('courses.id')
            ->get()
            ->getRowArray();

        if ($course) {
            // Get lessons for this course
            $lessons = $db->table('course_lessons')
                ->select('course_lessons.*, course_topics.*, course_lessons.id as id')
                ->join('course_topics', 'course_topics.id = course_lessons.topic_id', 'left')
                ->where('course_lessons.course_id', $id)
                ->orderBy('course_lessons.created_at', 'asc')
                ->get()
                ->getResultArray();

            $this->data['course'] = $course;

            foreach ($lessons as $key => $lesson) {
                $this->data['course']['lessons'][$lesson['topic_title']][$lesson['id']] = $lesson;
            }

            return $this->respond($this->data);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'Not found',
            ]);
        }
    }
}
