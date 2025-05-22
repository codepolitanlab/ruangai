<?php

namespace App\Pages\courses\lesson;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Lessons',
        'module' => 'course_lesson'
    ];

    public function getData($course_id, $lesson_id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();

        $db = \Config\Database::connect();
        // Get specific lesson
        $lesson = $db->table('course_lessons')
            ->select('course_lessons.*, courses.course_title, course_topics.topic_title')
            ->join('courses', 'courses.id = course_lessons.course_id')
            ->join('course_topics', 'course_topics.id = course_lessons.topic_id')
            ->where('course_lessons.course_id', $course_id)
            ->where('course_lessons.id', $lesson_id)
            ->get()
            ->getRowArray();

        if ($lesson) 
        {
            // Subquery untuk mendapatkan lesson yang sudah selesai
            $completedLessons = $db->table('course_lesson_progress')
                ->select('lesson_id')
                ->where('user_id', $jwt->user_id)
                ->where('course_id', $course_id)
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
                    course_lessons.lesson_order,
                    course_topics.topic_title
                ')
                ->join('course_topics', 'course_topics.id = course_lessons.topic_id')
                ->where('course_lessons.course_id', $course_id)
                ->orderBy('course_topics.topic_order', 'ASC')
                ->orderBy('course_lessons.lesson_order', 'ASC')
                ->get()
                ->getResultArray();

            // Menambahkan status completed ke setiap lesson
            $orderedLessons = [];
            foreach ($lessons as $lessonItem) {
                $orderedLessons[$lessonItem['id']] = $lessonItem;
                $orderedLessons[$lessonItem['id']]['is_completed'] = in_array($lessonItem['id'], $completedLessonIds);
            }

            $course['lessons'] = $orderedLessons;
            $lesson['is_completed'] = in_array($lesson['id'], $completedLessonIds);

            // Get previous and next lesson
            $IDs = array_keys($course['lessons']);
            $currentIndexID = array_search($lesson_id, $IDs);
            $prevLesson = $IDs[$currentIndexID - 1] ?? null;
            $nextLesson = $IDs[$currentIndexID + 1] ?? null;
            $lesson['prev_lesson'] = $prevLesson ? $course['lessons'][$prevLesson] : null;
            $lesson['next_lesson'] = $nextLesson ? $course['lessons'][$nextLesson] : null;

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
            ->select('courses.id as course_id, courses.slug as course_slug')
            ->join('courses', 'courses.id = course_lessons.course_id')
            ->where('course_lessons.id', $lesson_id)
            ->get()
            ->getRowArray();

        if (!$course) {
            return $this->respond([
               'status'    => 'failed',
               'message' => 'Course tidak ditemukan',
            ]);
        }

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
                'user_id'   => $jwt->user_id,
                'lesson_id' => $lesson_id,
                'course_id' => $course['course_id'],
            ];

            $inserted = $db->table('course_lesson_progress')->insert($progressData);

            if ($inserted) {
                return $this->respond([
                    'status'  => 'success',
                    'message' => 'Berhasil menyelesaikan materi',
                    'course'  => $course,
                ]);
            } else {
                return $this->respond([
                    'status'  => 'failed',
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
