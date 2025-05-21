<?php

namespace App\Pages\courses\lesson;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Lessons',
        'module' => 'course_lesson'
    ];

    public function getData($id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();

        $db = \Config\Database::connect();
        // Get specific lesson
        $lesson = $db->table('course_lessons')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if ($lesson) {
            // Get course with all its lessons
            $course = $db->table('courses')
                ->select('id, slug')
                ->where('courses.id', $lesson['course_id'])
                ->get()
                ->getRowArray();

            // Get all lessons for this course with proper ordering and completion status
            if ($course) {
                // Subquery untuk mendapatkan lesson yang sudah selesai
                $completedLessons = $db->table('course_lesson_progress')
                    ->select('lesson_id')
                    ->where('user_id', $jwt->user_id)
                    ->where('course_id', $course['id'])
                    ->get()
                    ->getResultArray();

                // Mengubah array hasil menjadi array sederhana berisi lesson_id
                $completedLessonIds = array_column($completedLessons, 'lesson_id');

                // Query utama untuk mendapatkan semua lesson dengan urutan yang benar
                $lessons = $db->table('course_lessons')
                    ->select('
                        course_lessons.id, 
                        course_lessons.lesson_title, 
                        course_lessons.topic_id,
                        course_topics.topic_order,
                        course_lessons.lesson_order
                    ')
                    ->join('course_topics', 'course_topics.id = course_lessons.topic_id')
                    ->where('course_lessons.course_id', $course['id'])
                    ->orderBy('course_topics.topic_order', 'ASC')
                    ->orderBy('course_lessons.lesson_order', 'ASC')
                    ->get()
                    ->getResultArray();

                // Menambahkan status completed ke setiap lesson
                foreach ($lessons as &$lessonItem) {
                    $lessonItem['is_completed'] = in_array($lessonItem['id'], $completedLessonIds);
                }

                $course['lessons'] = $lessons;
                $lesson['is_completed'] = in_array($lesson['id'], $completedLessonIds);
                // Get previous lesson
                $prevLesson = $db->table('course_lessons')
                    ->select('id, lesson_title')
                    ->where('course_id', $course['id'])
                    ->where('lesson_order <', $lesson['lesson_order'])
                    ->orderBy('lesson_order', 'DESC')
                    ->get()
                    ->getRowArray();
                // Get next lesson
                $nextLesson = $db->table('course_lessons')
                    ->select('id, lesson_title')
                    ->where('course_id', $course['id'])
                    ->where('lesson_order >', $lesson['lesson_order'])
                    ->orderBy('lesson_order', 'ASC')
                    ->get()
                    ->getRowArray();
                $lesson['prev_lesson'] = $prevLesson;
                $lesson['next_lesson'] = $nextLesson;
            }

            $this->data['course'] = $course;
            $this->data['lesson'] = $lesson;

            return $this->respond($this->data);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'Not found',
            ]);
        }
    }

    public function postIndex()
    {
        $data = $this->request->getPost();
        $Heroic = new \App\Libraries\Heroic();

        $jwt = $Heroic->checkToken();

        $db = \Config\Database::connect();
        $lesson_id = $data['lesson_id'];

        $course = $db->table('course_lessons')
            ->where('id', $lesson_id)
            ->get()
            ->getRowArray();

        // Check if the user has already completed this lesson
        $existingProgress = $db->table('course_lesson_progress')
            ->where('user_id', $jwt->user_id)
            ->where('lesson_id', $lesson_id)
            ->where('course_id', $course['course_id'])
            ->get()
            ->getRowArray();

        if (!$existingProgress) {

            // Insert new progress record
            $progressData = [
                'user_id' => $jwt->user_id,
                'lesson_id' => $lesson_id,
                'course_id' => $course['course_id'],
            ];

            $inserted = $db->table('course_lesson_progress')->insert($progressData);

            if ($inserted) {
                return $this->respond([
                    'status'    => 'success',
                    'message' => 'Berhasil menyelesaikan materi',
                ]);
            } else {
                return $this->respond([
                    'status'    => 'failed',
                    'message' => 'Gagal menyelesaikan materi',
                ]);
            }
        }

        return $this->respond([
           'status'    => 'failed',
           'message' => 'Anda sudah menyelesaikan materi ini',
        ]);
    }
}
