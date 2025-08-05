<?php

namespace App\Pages\home;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Homepage',
        'module'      => 'homepage',
        'active_page' => 'homepage',
    ];

    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);
        $this->data['name'] = $jwt->user['name'];

        $db = \Config\Database::connect();

        $this->data['courses'] = $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->countAllResults();

        $last_lesson = $db->table('course_lesson_progress')
            ->select('
                course_lessons.lesson_title as title, 
                course_lessons.id as lesson_id, 
                course_lessons.course_id,
                course_lesson_progress.created_at as last_progress_time,
                course_students.progress,
                courses.course_title,
                courses.slug
            ')
            ->join('course_lessons', 'course_lessons.id = course_lesson_progress.lesson_id')
            ->join('course_students', 'course_students.user_id = course_lesson_progress.user_id AND course_students.course_id = course_lesson_progress.course_id')
            ->join('courses', 'courses.id = course_lesson_progress.course_id')
            ->where('course_lesson_progress.user_id', $jwt->user_id)
            ->orderBy('course_lesson_progress.created_at', 'DESC')
            ->groupBy('
                course_lessons.id, 
                course_lessons.lesson_title, 
                course_lessons.id, 
                course_lessons.course_id,
                course_lesson_progress.created_at,
                course_students.progress,
                courses.course_title,
                courses.slug')
            ->limit(1)
            ->get()
            ->getRowArray();

        if ($last_lesson) {
            $this->data['last_lesson'] = $last_lesson;
        } else {
            $this->data['last_lesson'] = (object) [
                'title' => 'Belum ada kelas',
                'lesson_id' => 1,
                'course_id' => 1,
                'last_progress_time' => 0,
                'progress' => 0,
                'course_title' => 'Dasar dan Penggunaan Generative AI',
                'slug' => 'dasar-dan-penggunaan-generative-ai',
            ];
        }

        // Get course_students
        $this->data['student'] = $db->table('course_students')
            ->select('progress, cert_claim_date, cert_code, expire_at')
            ->where('course_id', 1)
            ->where('user_id', $jwt->user_id)
            ->get()
            ->getRowArray();

        $this->data['is_expire'] = $this->data['student']['expire_at'] && $this->data['student']['expire_at'] < date('Y-m-d H:i:s') ? true : false;

        return $this->respond($this->data);
    }
}
