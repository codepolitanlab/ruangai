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
        $jwt = $Heroic->checkToken(true);
        $this->data['name'] = $jwt->user['name'];

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
            $this->data['course'] = $course;

            // Get count live attendance user
            $this->data['live_attendance'] = $db->table('live_attendance')
                ->where('user_id', $jwt->user_id)
                ->where('course_id', $id)
                ->countAllResults();

            // Get total live_meetings
            $this->data['live_meetings'] = $db->table('live_meetings')
                ->select('live_meetings.id')
                ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id AND live_batch.id = '.$course['current_batch_id'])
                ->where('course_id', $id)
                ->countAllResults();

                $this->data['course_completed'] = $this->data['total_lessons'] == $this->data['lesson_completed'] && $this->data['live_meetings'] >= 3 ? true : false;

            return $this->respond($this->data);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'Not found',
            ]);
        }
    }
}
