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
        $Heroic = new \App\Libraries\Heroic();
        $user = $Heroic->checkToken();
        
        $db = \Config\Database::connect();
        $this->data['profile'] = $db->table('users')
            ->select('users.id, users.name, users.username,
                users.email, users.avatar, users.phone')
            ->where('users.id', $user->user_id)
            ->get()->getRowArray();

        return $this->respond($this->data);
    }

}