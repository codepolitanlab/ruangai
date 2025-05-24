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
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();
        
        $db = \Config\Database::connect();
        $course = $db->table('courses')
            ->where('courses.id', $id)
            ->groupBy('courses.id')
            ->get()
            ->getRowArray();

        if ($course) {
            // Get completed lessons for current user
            $completedLessons = $db->table('course_lesson_progress')
                ->select('lesson_id')
                ->where('user_id', $jwt->user_id)
                ->where('course_id', $id)
                ->get()
                ->getResultArray();

            $completedLessonIds = array_column($completedLessons, 'lesson_id');

            // Get lessons for this course
            $lessons = $db->table('course_lessons')
                ->select('course_lessons.*, course_topics.*, course_lessons.id as id')
                ->join('course_topics', 'course_topics.id = course_lessons.topic_id', 'left')
                ->where('course_lessons.course_id', $id)
                ->where('course_lessons.deleted_at', null)
                ->orderBy('course_topics.topic_order', 'ASC')
                ->orderBy('course_lessons.lesson_order', 'ASC')
                ->get()
                ->getResultArray();

            $this->data['course'] = $course;

            foreach ($lessons as $key => $lesson) {
                // Tambahkan status is_completed ke setiap lesson
                $lesson['is_completed'] = in_array($lesson['id'], $completedLessonIds);
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
