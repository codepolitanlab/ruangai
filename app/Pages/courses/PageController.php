<?php

namespace App\Pages\courses;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Courses',
        'module'      => 'course_list',
        'active_page' => 'my_courses',
    ];

    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);
        $this->data['name'] = $jwt->user['name'];
        $db = \Config\Database::connect();

        // Subquery untuk menghitung total modul per course
        $totalModuleSubquery = "(SELECT COUNT(id) 
                        FROM course_lessons 
                        WHERE course_lessons.course_id = courses.id) 
                        AS total_module";

        // Subquery untuk menghitung modul yang sudah selesai oleh user per course
        $totalCompletedSubquery = "(SELECT COUNT(clp.id) 
                            FROM course_lesson_progress clp
                            JOIN course_lessons cl ON clp.lesson_id = cl.id
                            WHERE cl.course_id = courses.id AND clp.user_id = {$db->escape($jwt->user_id)})
                            AS total_completed";

        $this->data['courses'] = $db->table('course_students')
            ->select('courses.thumbnail, courses.cover, courses.course_title, course_students.progress, courses.slug, courses.id')
            ->select($totalModuleSubquery)
            ->select($totalCompletedSubquery)
            ->join('courses', 'courses.id = course_students.course_id')
            ->where('course_students.user_id', $jwt->user_id)
            ->get()
            ->getResult();

        $this->data['last_lesson'] = $db->table('course_lesson_progress')
            ->select('
                course_lessons.lesson_title as title, 
                course_lessons.id as lesson_id, 
                course_lessons.course_id,
                course_lesson_progress.created_at as last_progress_time,
                course_students.progress
            ')
            ->join('course_lessons', 'course_lessons.id = course_lesson_progress.lesson_id')
            ->join('course_students', 'course_students.user_id = course_lesson_progress.user_id AND course_students.course_id = course_lesson_progress.course_id')
            ->where('course_lesson_progress.user_id', $jwt->user_id)
            ->orderBy('course_lesson_progress.created_at', 'DESC')
            ->groupBy('
                course_lessons.lesson_title, 
                course_lessons.id, 
                course_lessons.course_id,
                course_lesson_progress.created_at,
                course_students.progress
            ')
            ->limit(1)
            ->get()
            ->getRowArray() ?? [];

        $this->data['premium_courses'] = $db->table('courses')->where('id !=', 1)->get()->getResult();

        return $this->respond($this->data);
    }
}
