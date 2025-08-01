<?php

namespace Course\Controllers;

class Quiz extends Lesson
{
    public $data = [
        'page_title' => 'Quiz',
        'module'     => 'elearning',
        'submodule'  => 'course',
    ];

    public function index($course_id, $topic_id = null, $lesson_id = null)
    {
        $this->initBasicCourseData($course_id);

        if ($topic_id) {
            $TopicModel          = model('CourseTopicModel');
            $this->data['topic'] = $TopicModel->table('course_topics')
                ->where('id', $topic_id)
                ->where('course_id', $course_id)
                ->get()
                ->getRowArray();
        }

        if ($lesson_id) {
            $LessonModel          = model('CourseLessonModel');
            $this->data['lesson'] = $LessonModel->table('course_lessons')
                ->where('id', $lesson_id)
                ->where('topic_id', $topic_id)
                ->where('course_id', $course_id)
                ->get()
                ->getRowArray();
        }

        return view('Course\Views\lesson\quiz', $this->data);
    }

    public function save()
    {
        $postData    = $this->request->getPost();
        $LessonModel = model('CourseLessonModel');

        // Edit
        if ($postData['lesson_id'] ?? null) {
            $data = [
                'course_id'    => (int) $postData['course_id'],
                'topic_id'     => (int) $postData['topic_id'],
                'lesson_title' => $postData['lesson_title'],
                'lesson_slug'  => $postData['lesson_slug'],
                'quiz'         => $postData['quiz'],
                'status'       => (int) ($postData['status'] ?? 0),
                'free'         => (int) ($postData['free'] ?? 0),
            ];
            $LessonModel->update($postData['lesson_id'], $data);
            session()->setFlashdata('success_message', 'Quiz telah diperbaharui');

            // Clear cache lesson
            cache()->delete('course_' . $postData['lesson_id'] . '_lessons');
            cache()->delete('lesson_' . $postData['lesson_id']);

            return redirectPage(urlScope() . '/course/' . $postData['course_id'] . '/topic/' . $postData['topic_id'] . '/quiz/' . $postData['lesson_id']);
            // Insert
        }

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
            'course_id'    => (int) $postData['course_id'],
            'topic_id'     => (int) $postData['topic_id'],
            'lesson_title' => $postData['lesson_title'],
            'lesson_order' => $lastOrder['lesson_order'] + 1,
            'lesson_slug'  => $postData['lesson_slug'],
            'quiz'         => $postData['quiz'],
            'type'         => 'quiz',
            'status'       => (int) ($postData['status'] ?? 0),
            'free'         => (int) ($postData['free'] ?? 0),
        ];

        $LessonModel->insert($data);
        $lesson_id = $LessonModel->getInsertID();

        // Clear cache lesson
        cache()->delete('course_' . $lesson_id . '_lessons');
        cache()->delete('lesson_' . $lesson_id);

        session()->setFlashdata('success_message', 'Quiz telah disimpan');

        return redirectPage(urlScope() . '/course/' . $postData['course_id'] . '/topic/' . $postData['topic_id'] . '/quiz/' . $lesson_id);
    }
}
