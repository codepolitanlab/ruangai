<?php 

namespace App\Pages\profile;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => 'Profile',
        'module'     => 'profile'
    ];

    public function getData()
    {
        // Get database pesantren
        $Auth = new \App\Libraries\Auth();
        $user = $Auth->checkToken(null, true);
        
        $this->data['profile'] = $user;

        return $this->respond($this->data);
    }

}