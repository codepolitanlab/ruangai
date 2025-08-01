<?php

namespace App\Pages\zpanel\course\lesson\topic;

use App\Pages\zpanel\course\lesson\PageController as CourseLessonController;

class PageController extends CourseLessonController
{
    public $data = [
        'page_title' => 'Topik Kelas',
    ];

    public function getIndex($course_id, $topic_id = null)
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

        return pageView('zpanel/course/lesson/topic/index', $this->data);
    }

    public function postIndex($course_id, $topic_id = null)
    {
        $postData = $this->request->getPost();

        $TopicModel = model('CourseTopic');

        // Update
        if ($topic_id) {
            $data = [
                'topic_title' => $postData['topic_title'],
                'topic_slug'  => url_title($postData['topic_title'], '-', true),
                'free'        => (int) ($postData['free'] ?? 0),
                'status'      => (int) ($postData['status'] ?? 0),
            ];
            $TopicModel->update($topic_id, $data);

            return redirectPage('/zpanel/course/lesson/topic/' . $course_id . '/' . $topic_id);
            // Insert
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

        return redirectPage('/zpanel/course/lesson/topic/' . $course_id . '/' . $TopicModel->getInsertID());
    }

    public function getDeleteTopic($course_id, $topic_id)
    {
        $TopicModel = model('CourseTopic');

        $hasLessons = $TopicModel->hasLessons($topic_id);
        if ($hasLessons) {
            session()->setFlashdata('error_message', 'Tidak dapat menghapus topik karena masih memiliki materi');

            return redirectPage('/zpanel/course/lesson/topic/' . $course_id . '/' . $topic_id);
        }

        $TopicModel->delete($topic_id);
        session()->setFlashdata('success_message', 'Topik telah dihapus');

        return redirectPage('/zpanel/course/lesson/' . $course_id);
    }
}
