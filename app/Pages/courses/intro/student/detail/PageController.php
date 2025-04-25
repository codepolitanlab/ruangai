<?php namespace App\Pages\courses\intro\student\detail;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => 'Student Detail'
    ];

    public function getData($id)
    {
        $db = \Config\Database::connect();

        $this->data['student'] = $db->table('users')
                                    ->select('*')
                                    ->where('id', $id)
                                    ->get()
                                    ->getRowArray();

        if ($this->data['student'])
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
