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
            ->select('courses.thumbnail,  courses.course_title, course_students.progress, courses.slug, courses.id')
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

        // Premium Class Data Static
        $this->data['premium_courses'] = [
                (object)[
                    'title' => 'Kelas AI for SaaS Builder',
                    'description' => 'Bangun Web AI Pertamamu dan Pelajari Cara Monetisasinya.',
                    'teaser_url' => 'https://ruangai.com/premium-class/ai',
                    'cover' => 'https://ik.imagekit.io/56xwze9cy/ruangai/mentor-adel.png',
                    'embed' => '<iframe src="https://1drv.ms/v/c/d1ed896f6a378b33/IQSgTjY8-6FCSaMz98yTMguVAf--SpKFf7LNd7C7wJ5kw0s" class="w-100 h-100" frameborder="0" scrolling="no" allowfullscreen></iframe>'
                ],
                (object)[
                    'title' => 'Kelas AI for Academics',
                    'description' => 'Tulis karya ilmiah lebih cepat dan etis dengan memanfaatkan alat AI.',
                    'teaser_url' => 'https://ruangai.com/premium-class/data-science',
                    'cover' => 'https://ik.imagekit.io/56xwze9cy/ruangai/mentor-felisha.png',
                    'embed' => '<iframe src="https://1drv.ms/v/c/d1ed896f6a378b33/IQRRUTdDz5SKSoN0vhVEs6zDAeE9DxXWJeWVenMioqbAyrM" class="w-100 h-100" frameborder="0" scrolling="no" allowfullscreen></iframe>'
                ],
                (object)[
                    'title' => 'Kelas AI for Smart Creators',
                    'description' => 'Lebih kreatif dan bikin kontenmu naik level dengan AI.',
                    'teaser_url' => 'https://ruangai.com/premium-class/web-development',
                    'cover' => 'https://ik.imagekit.io/56xwze9cy/ruangai/mentor-vira.png',
                    'embed' => '<iframe src="https://1drv.ms/v/c/d1ed896f6a378b33/IQSAi7mWIki_SKc-_2fmsMtsAVKxxNrbTapO3MbMJYJufA0" class="w-100 h-100" frameborder="0" scrolling="no" allowfullscreen></iframe>'
                ],
                (object)[
                    'title' => 'Kelas AI for Digital Storyteller',
                    'description' => 'Kuasai storytelling dan ubah jadi karya digital dengan AI.',
                    'teaser_url' => 'https://ruangai.com/premium-class/web-development',
                    'cover' => 'https://ik.imagekit.io/56xwze9cy/ruangai/mentor-aji.png',
                    'embed' => '<iframe src="https://1drv.ms/v/c/d1ed896f6a378b33/IQTQJtgrJdd6S7Z5wLzXaViAAXUHzb7zVrvzxHEBEIMYpQo" class="w-100 h-100" frameborder="0" scrolling="no" allowfullscreen></iframe>'
                ],
                (object)[
                    'title' => 'Kelas AI for Coding Assist',
                    'description' => 'Bangun aplikasi lebih cepat dan efisien dengan bantuan AI.',
                    'teaser_url' => 'https://ruangai.com/premium-class/web-development',
                    'cover' => 'https://image.web.id/images/clipboard-image-1754379412.png',
                    'embed' => ''
                ],
            ];

        return $this->respond($this->data);
    }
}
