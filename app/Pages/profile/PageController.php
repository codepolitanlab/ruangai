<?php namespace App\Pages\profile;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController {

    use ResponseTrait;

    public $data = [
        'page_title' => 'Profile'
    ];

    public function getData()
    {
        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();
        $user = $Heroic->checkToken();
        $data = [];

        $data['profile'] = $db->table('users')
            ->select('users.id, users.name, users.username,
                users.email, users.avatar, users.phone, 
                users.short_description,
                mein_user_profile.birthday, mein_user_profile.jobs,
                mein_user_profile.status_marital, mein_user_profile.gender,
                role_slug as role')
            ->join('mein_user_profile', 'mein_user_profile.user_id = users.id', 'left')
            ->join('mein_roles', 'mein_roles.id = users.role_id')
            ->where('users.id', $user->user_id)
            ->get()->getRowArray();

        return $this->respond([
            'response_code'    => 200,
            'response_message' => 'success',
            'data'             => $data
        ]);
    }

}