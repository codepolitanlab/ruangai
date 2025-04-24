<?php namespace App\Pages\courses\intro\live_session\detail;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => 'Detail Live Session'
    ];

    public function getData($id)
    {
        $db = \Config\Database::connect();
        $this->data['live_sessions'] = $db->table('live_session_sub')
                                    ->select('*')
                                    ->where('live_session_id', $id)
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
