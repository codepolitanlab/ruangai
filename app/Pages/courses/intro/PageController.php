<?php

namespace App\Pages\courses\intro;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Detail Kelas',
        'module'      => 'course_intro',
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
            $completedLessons = $db->table('course_lessons')
                ->select('count(course_lessons.id) as total_lessons, count(course_lesson_progress.user_id) as completed')
                ->join('course_lesson_progress', 'course_lesson_progress.lesson_id = course_lessons.id AND user_id = '.$jwt->user_id, 'left')
                ->where('course_lessons.course_id', $id)
                ->get()
                ->getRowArray();

            $this->data['total_lessons'] = $completedLessons['total_lessons'] ?? 1;
            $this->data['lesson_completed'] = $completedLessons['completed'] ?? 0;
            $this->data['percent_completed'] = $this->data['lesson_completed']/$this->data['total_lessons'] * 100;
            $this->data['course'] = $course;

            return $this->respond($this->data);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'Not found',
            ]);
        }
    }
}
