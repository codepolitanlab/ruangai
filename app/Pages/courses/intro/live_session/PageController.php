<?php namespace App\Pages\courses\intro\live_session;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Live Session"
    ];

    public function getData()
    {
        $db = \Config\Database::connect();
        $live_sessions = $db->table('live_sessions')
            ->get()
            ->getResultArray();

        if ($live_sessions) {

            $data['live_sessions'] = $live_sessions;

            return $this->respond([
                'response_code'    => 200,
                'response_message' => 'success',
                'data'             => $data
            ]);
        } else {
            return $this->respond([
                'response_code'    => 404,
                'response_message' => 'Not found',
            ]);
        }
    }
}
