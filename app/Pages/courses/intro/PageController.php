<?php

namespace App\Pages\courses\intro;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController
{
    use ResponseTrait;

    public function getContent()
    {
        $data['page_title'] = 'Detail Kelas';

        return pageView('courses/intro/index', $data);
    }

    public function getCourse($id)
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

            return $this->respond(['status' => 'success', 'data' => $data]);
        } else {
            return $this->respond(['status' => 'failed', 'message' => 'Not found']);
        }
    }
}
