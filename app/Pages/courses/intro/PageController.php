<?php

namespace App\Pages\courses\intro;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Detail Kelas',
        'module'      => 'home',
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
                ->where('course_id', $id)
                ->orderBy('created_at', 'asc')
                ->get()
                ->getResultArray();

            $this->data['course'] = $course;
            $this->data['course']['lessons'] = $lessons;

            return $this->respond($this->data);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'Not found',
            ]);
        }
    }
}
