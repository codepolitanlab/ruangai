<?php

namespace App\Pages\courses\intro\student;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Students',
        'active_page' => 'student',
    ];

    public function getData($course_id)
    {
        $db                   = \Config\Database::connect();
        $this->data['course'] = $db->table('courses')
            ->select('course_title, total_module, total_student')
            ->where('courses.id', $course_id)
            ->groupBy('courses.id')
            ->get()
            ->getRowArray();

        $this->data['students'] = $db->table('course_students')
            ->select('users.id as user_id, users.name, users.avatar, course_students.created_at as joined_at')
            ->join('users', 'users.id = course_students.user_id', 'left')
            ->where('course_students.course_id', $course_id)
            ->groupBy('course_students.id')
            ->get()
            ->getResultArray();

        if (! $this->data['students']) {
            $this->data['response_code']    = 404;
            $this->data['response_message'] = 'Not found';
        }

        return $this->respond($this->data);
    }
}
