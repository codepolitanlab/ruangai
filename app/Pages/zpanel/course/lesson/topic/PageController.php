<?php namespace App\Pages\zpanel\course\lesson\topic;

use App\Pages\zpanel\AdminController;

class PageController extends AdminController 
{
    public $data = [
        'page_title' => "Topik Kelas"
    ];

    public function getIndex($course_id)
    {
        $db = \Config\Database::connect();
        $this->data['course'] = $db->table('courses')->where('id', $course_id)->get()->getRowArray();

        return pageView('zpanel/course/lesson/topic/index', $this->data);
    }

    public function postIndex($course_id)
    {
        $postData = $this->request->getPost();
        
        $CourseTopicModel = model('CourseTopic');
        $lastTopic = $CourseTopicModel->select('topic_order')->where('course_id', $course_id)->orderBy('topic_order', 'DESC')->first();

        $data = [
            'course_id'     => (int)$course_id,
            'topic_title'   => $postData['topic_title'],
            'topic_slug'    => url_title($postData['topic_title'], '-', true),
            'topic_order'   => (int)($lastTopic['topic_order'] ?? 0) + 1,
            'free'          => (int)($postData['free'] ?? 0),
            'status'        => (int)($postData['status'] ?? 0)
        ];
        $CourseTopicModel->insert($data);

        return redirectPage('/zpanel/course/lesson/topic/'.$course_id);
    }
}
