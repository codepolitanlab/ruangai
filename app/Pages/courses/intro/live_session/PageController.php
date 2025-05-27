<?php namespace App\Pages\courses\intro\live_session;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title'  => "Live Session",
        'module'      => 'course_live',
        'active_page' => 'live',
    ];

    public function getData($course_id)
    {
        $db = \Config\Database::connect();
        $this->data['course'] = $db->table('courses')
                                    ->where('courses.id', $course_id)
                                    ->groupBy('courses.id')
                                    ->get()
                                    ->getRowArray();

        $this->data['live_sessions'] = $db->table('live_meetings')
                                            ->where('live_batch_id', $this->data['course']['current_batch_id'])
                                            ->where('deleted_at', null)
                                            ->get()
                                            ->getResultArray();

        if (! $this->data['live_sessions'])
        {
            $this->data['response_code'] = 404;
            $this->data['response_message'] = 'Not found';
        }

        return $this->respond($this->data);
    }
}
