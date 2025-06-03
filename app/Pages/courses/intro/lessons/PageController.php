<?php

namespace App\Pages\courses\intro\lessons;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Daftar Materi',
        'module'      => 'course_lesson',
        'active_page' => 'materi',
    ];

    public function getData($id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();
        
        $db = \Config\Database::connect();

        // Get course
        if (! $course = cache('course_'.$id)) {
            $course = $db->table('courses')
                        ->where('id', $id)
                        ->get()
                        ->getRowArray();
                        
            // Save into the cache for 5 minutes
            cache()->save('course_'.$id, $course, 3600);
        }
        $this->data['course'] = $course;

        if ($course) {
            // Get completed lessons for current user
            $completedLessons = $db->table('course_lesson_progress')
                ->select('lesson_id')
                ->where('user_id', $jwt->user_id)
                ->where('course_id', $id)
                ->get()
                ->getResultArray();

            $completedLessonIds = array_column($completedLessons, 'lesson_id');

            // Get lessons for this course
            if (! $lessons = cache('course_'.$id.'_lessons')) {
                $lessons = $db->table('course_lessons')
                    ->select('course_lessons.*, course_topics.*, course_lessons.id as id')
                    ->join('course_topics', 'course_topics.id = course_lessons.topic_id', 'left')
                    ->where('course_lessons.course_id', $id)
                    ->where('course_lessons.deleted_at', null)
                    ->orderBy('course_topics.topic_order', 'ASC')
                    ->orderBy('course_lessons.lesson_order', 'ASC')
                    ->get()
                    ->getResultArray();
                
                // Save into the cache for 1 hours
                cache()->save('course_'.$id.'_lessons', $lessons, 3600);
            }

            $lessonsCompleted = [];
            $numCompleted = 0;
            foreach ($lessons as $key => $lesson) {
                // Tambahkan status is_completed ke setiap lesson
                $this->data['course']['lessons'][$lesson['topic_title']][$lesson['id']] = $lesson;
                $lessonsCompleted[] = [
                    'id'        => $lesson['id'], 
                    'completed' => in_array($lesson['id'], $completedLessonIds)
                ];
                if(in_array($lesson['id'], $completedLessonIds)) $numCompleted++;
            }
            $this->data['lessonsCompleted'] = $lessonsCompleted;
            $this->data['numCompleted'] = $numCompleted;

            return $this->respond($this->data);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'Not found',
            ]);
        }
    }
}
