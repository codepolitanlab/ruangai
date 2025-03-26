<?php

namespace App\Pages\courses\intro;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController
{
    use ResponseTrait;

    public $data = [
        'page_title' => "Detail Kelas"
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

            $data['course'] = $course;
            $data['course']['lessons'] = $lessons;

            return $this->respond([
                'response_code'    => 200,
                'response_message' => 'success',
                'data'             => $data
            ]);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'Not found',
            ]);
        }
    }
}
