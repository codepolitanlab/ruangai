<?php namespace App\Pages\courses\intro\live_session;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Live Session"
    ];

    public function getData($course_id)
    {
        $db = \Config\Database::connect();
        $this->data['course'] = $db->table('courses')
                                    ->select('*')
                                    ->where('courses.id', $course_id)
                                    ->groupBy('courses.id')
                                    ->get()
                                    ->getRowArray();

        $this->data['live_sessions'] = $db->table('live_sessions')
                                            ->get()
                                            ->getResultArray();

        if ($this->data['live_sessions'])
        {
            return $this->respond($this->data);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'Not found',
            ]);
        }
    }
}
