<?php

namespace App\Pages\profile;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Profile',
        'module'     => 'profile',
        'body_class' => 'rd-dashboard-page',
    ];

    public function getData()
    {
        // Get database pesantren
        $Auth = new \App\Libraries\Auth();
        $user = $Auth->checkToken(null, true);

        // Ambil bio dari user_profiles
        $db = \Config\Database::connect();
        $profile = $db->table('user_profiles')
            ->select('bio')
            ->where('user_id', $user['user_id'] ?? ($user['user']['id'] ?? null))
            ->where('deleted_at', null)
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();

        $user['bio'] = $profile['bio'] ?? null;

        $this->data['profile'] = $user;

        return $this->respond($this->data);
    }
}
