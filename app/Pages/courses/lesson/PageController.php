<?php namespace App\Pages\courses\lesson;

use App\Pages\BaseController;

class PageController extends BaseController 
{

    public $data = [
        'page_title' => 'Lessons',
        'module' => 'course_lesson'
    ];

    public function getData($id)
    {
        $db = \Config\Database::connect();
        // Get specific lesson
        $lesson = $db->table('course_lessons')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if ($lesson) {
            // Get course with all its lessons
            $course = $db->table('courses')
                ->select('courses.*, COUNT(cl.id) as total_lessons')
                ->join('course_lessons as cl', 'courses.id = cl.course_id', 'left')
                ->where('courses.id', $lesson['course_id'])
                ->groupBy('courses.id')
                ->get()
                ->getRowArray();

            // Get all lessons for this course
            if ($course) {
                $course['lessons'] = $db->table('course_lessons')
                    ->where('course_id', $course['id'])
                    ->orderBy('created_at', 'asc')
                    ->get()
                    ->getResultArray();
            }

            $this->data['course'] = $course;
            $this->data['lesson'] = $lesson;

            return $this->respond($this->data);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'NOt found',
            ]);
        }
    }
}
