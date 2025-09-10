<?php

namespace App\Pages\courses\reward;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Reward',
        'module'      => 'reward',
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

        $this->data['user_token'] = count(model('UserToken')->getAllTokenActive($jwt->user_id));

        return $this->respond($this->data);
    }
}
