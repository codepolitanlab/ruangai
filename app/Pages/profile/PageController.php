<?php namespace App\Pages\profile;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController {

    public function getContent()
    {
        return pageView('profile/index', $this->data);
    }

    public function getSupply()
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

        return $this->respond($data);
    }

}