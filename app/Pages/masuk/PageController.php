<?php

namespace App\Pages\masuk;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Masuk',
    ];

    // Check login
    public function postIndex()
    {
        $username = strtolower($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        $Heroic = new \App\Libraries\Heroic();
        $db     = \Config\Database::connect();

        // Check login to database directly using $db
        $Auth                      = new \App\Libraries\Auth();
        [$status, $message, $user] = $Auth->login($username, $password);

        return $this->respond([
            'found'   => $status === 'success' ? 1 : 0,
            'message' => $message,
            'jwt'     => $user['jwt'] ?? '',
            'user'    => $user ?? [],
        ]);
    }

    public function getTest()
    {
        $Phpass = new \App\Libraries\Phpass();
        dd($Phpass->CheckPassword('bismillah', '$P$BLZDsvTOH.MxpmbpMSXj86LPJ8Tj4A0'));
    }
}
