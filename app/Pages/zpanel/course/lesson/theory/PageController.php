<?php

namespace App\Pages\zpanel\course\lesson\theory;

use App\Pages\zpanel\course\lesson\PageController as CourseLessonController;

class PageController extends CourseLessonController
{
    public $data = [
        'page_title' => "Materi"
    ];

    public function getIndex($course_id, $topic_id = null, $lesson_id = null)
    {
        $this->initBasicCourseData($course_id);

        if ($topic_id) {
            $TopicModel = model('CourseTopic');
            $this->data['topic'] = $TopicModel->table('course_topics')
                ->where('id', $topic_id)
                ->where('course_id', $course_id)
                ->get()
                ->getRowArray();
        }

        if ($lesson_id) {
            $LessonModel = model('CourseLesson');
            $this->data['lesson'] = $LessonModel->table('course_lessons')
                ->where('id', $lesson_id)
                ->where('topic_id', $topic_id)
                ->where('course_id', $course_id)
                ->get()
                ->getRowArray();
        }

        return pageView('zpanel/course/lesson/theory/index', $this->data);
    }

    public function postIndex()
    {
        $postData = $this->request->getPost();
        $LessonModel = model('CourseLesson');

        // Edit
        if ($postData['lesson_id'] ?? null) 
        {
            $data = [
                'course_id'      => (int)$postData['course_id'],
                'topic_id'       => (int)$postData['topic_id'],
                'lesson_title'   => $postData['lesson_title'],
                'lesson_slug'    => $postData['lesson_slug'],
                'text'           => $postData['text'],
                'status'         => (int)($postData['status'] ?? 0),
                'free'           => (int)($postData['free'] ?? 0),
                'video_diupload' => $postData['video_diupload'] ?? null,
                'video_bunny'    => $postData['video_bunny'] ?? null,
                'duration'       => $postData['duration'],
            ];
            $LessonModel->update($postData['lesson_id'], $data);
            session()->setFlashdata('success_message', 'Materi telah diperbaharui');
            return redirectPage('/zpanel/course/lesson/theory/' . $postData['course_id'] . '/' . $postData['topic_id'] . '/' . $postData['lesson_id']);

        // Insert
        } else {


            // Ambil lesson_order terakhir
            $lastOrder = $LessonModel->table('course_lessons')
                ->select('lesson_order')
                ->where('topic_id', $postData['topic_id'])
                ->where('course_id', $postData['course_id'])
                ->where('deleted_at', null)
                ->orderBy('lesson_order', 'DESC')
                ->first();

            // Simpan postData
            $data = [
                'course_id'      => (int)$postData['course_id'],
                'topic_id'       => (int)$postData['topic_id'],
                'lesson_title'   => $postData['lesson_title'],
                'lesson_order'   => ($lastOrder['lesson_order'] ?? 0) + 1,
                'lesson_slug'    => $postData['lesson_slug'],
                'text'           => $postData['text'],
                'type'           => 'thelastOrderory',
                'status'         => (int)($postData['status'] ?? 0),
                'free'           => (int)($postData['free'] ?? 0),
                'video_diupload' => $postData['video_diupload'] ?? null,
                'video_bunny'    => $postData['video_bunny'] ?? null,
                'duration'       => $postData['duration'],
            ];

            $LessonModel->insert($data);
            $lesson_id = $LessonModel->getInsertID();
            session()->setFlashdata('success_message', 'Materi telah disimpan');
            return redirectPage('/zpanel/course/lesson/theory/' . $postData['course_id'] . '/' . $postData['topic_id'] . '/' . $lesson_id);
        }
    }
}
