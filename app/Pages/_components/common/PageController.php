<?php

namespace App\Pages\_components\common;

use App\Pages\BaseController;

class PageController extends BaseController
{
    // Supply site setting and current user
    public function getSettings($pesantrenID = null)
    {
        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db     = \Config\Database::connect();

        $settingQuery = config('App');

        $userToken = $Heroic->getUserToken();
        if ($userToken) {
            $userQuery = $db->table('users')
                ->where('id', $userToken->user_id)
                ->get()
                ->getRowArray();
            $user = [
                'name'      => $userQuery['name'] ?? '',
                'email'     => $userQuery['email'] ?? '',
                'phone'     => $userQuery['phone'] ?? '',
                'avatar'    => $userQuery['avatar'] ?? '',
                'date_join' => $userQuery['created_at'] ?? '',
            ];
        }

        // Get active program from table events
        $activeProgram = $db->table('events')
            ->select('code')
            ->where('status', 'ongoing')
            ->get()
            ->getRowArray()['code'] ?? null;

        return $this->respond([
            'settings' => $settingQuery, 
            'user' => $user ?? [], 
            'activeProgram' => $activeProgram ?? []
        ]);
    }
}
