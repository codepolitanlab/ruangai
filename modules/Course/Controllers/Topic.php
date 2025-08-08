<?php

namespace Course\Controllers;

class Topic extends Lesson
{
    public $data = [
        'page_title' => 'Topik Kelas',
        'module'     => 'elearning',
        'submodule'  => 'course',
    ];

    public function index($course_id, $topic_id = null)
    {
        $this->initBasicCourseData($course_id);

        $db = \Config\Database::connect();

        if ($topic_id) {
            $this->data['topic'] = $db->table('course_topics')
                ->where('id', $topic_id)
                ->where('course_id', $course_id)
                ->get()
                ->getRowArray();
        }

        return view('Course\Views\lesson\topic', $this->data);
    }

    public function save($course_id, $topic_id = null)
    {
        $postData = $this->request->getPost();

        $TopicModel = model('Course\Models\CourseTopicModel');

        // Update
        if ($topic_id) {
            $data = [
                'topic_title' => $postData['topic_title'],
                'topic_slug'  => url_title($postData['topic_title'], '-', true),
                'free'        => (int) ($postData['free'] ?? 0),
                'status'      => (int) ($postData['status'] ?? 0),
            ];
            $TopicModel->update($topic_id, $data);

            if ($TopicModel->affectedRows() > 0) {
                session()->setFlashdata('success_message', 'Topik telah diperbaharui');
            } else {
                session()->setFlashdata('error_message', 'Topik gagal diperbaharui');
            }

            return redirectPage(urlScope() . '/course/' . $course_id . '/topic/' . $topic_id);
        }

        $lastTopic = $TopicModel
            ->select('topic_order')
            ->where('course_id', $course_id)
            ->where('deleted_at', null)
            ->orderBy('topic_order', 'DESC')
            ->first();

        $data = [
            'course_id'   => (int) $course_id,
            'topic_title' => $postData['topic_title'],
            'topic_slug'  => url_title($postData['topic_title'], '-', true),
            'topic_order' => (int) ($lastTopic['topic_order'] ?? 0) + 1,
            'free'        => (int) ($postData['free'] ?? 0),
            'status'      => (int) ($postData['status'] ?? 0),
        ];
        $TopicModel->insert($data);
        if ($TopicModel->getInsertID() > 0) {
            session()->setFlashdata('success_message', 'Topik telah ditambahkan');
        } else {
            session()->setFlashdata('error_message', 'Topik gagal ditambahkan');
        }

        return redirectPage(urlScope() . '/course/' . $course_id . '/topic/' . $TopicModel->getInsertID());
    }

    public function delete($course_id, $topic_id)
    {
        $TopicModel = model('Course\Models\CourseTopicModel');

        $hasLessons = $TopicModel->hasLessons($topic_id);
        if ($hasLessons) {
            session()->setFlashdata('error_message', 'Tidak dapat menghapus topik karena masih memiliki materi');

            return redirectPage(urlScope() . '/course/' . $course_id . '/topic/' . $topic_id);
        }

        $TopicModel->delete($topic_id);
        session()->setFlashdata('success_message', 'Topik telah dihapus');

        return redirectPage(urlScope() . '/course/' . $course_id);
    }
}
