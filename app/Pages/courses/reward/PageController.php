<?php

namespace App\Pages\courses\reward;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Reward',
        'module'      => 'learn',
        'active_page' => 'reward',
    ];

    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        $db = \Config\Database::connect();

        $this->data['premium_courses'] = $db->table('courses')
            ->where('id !=', 1)
            ->where('deleted_at', null)
            ->get()
            ->getResult();

        return $this->respond($this->data);
    }
}
