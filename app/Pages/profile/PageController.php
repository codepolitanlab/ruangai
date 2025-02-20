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
        $Tarbiyya = new \App\Libraries\Tarbiyya();
        $db = \Config\Database::connect();
        $user = $Tarbiyya->checkToken();
        $data = [];

        $data['profile'] = $db->table('mein_users')
            ->select('mein_users.id, mein_users.name, mein_users.username,
                mein_users.email, mein_users.avatar, mein_users.phone, 
                mein_users.short_description,
                mein_user_profile.birthday, mein_user_profile.jobs,
                mein_user_profile.status_marital, mein_user_profile.gender,
                role_slug as role')
            ->join('mein_user_profile', 'mein_user_profile.user_id = mein_users.id', 'left')
            ->join('mein_roles', 'mein_roles.id = mein_users.role_id')
            ->where('mein_users.id', $user->user_id)
            ->get()->getRowArray();

        return $this->respond($data);
    }

}