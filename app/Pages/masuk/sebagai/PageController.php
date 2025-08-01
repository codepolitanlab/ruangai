<?php

namespace App\Pages\masuk\sebagai;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Masuk Sebagai',
    ];

    // Check login
    public function postIndex()
    {
        $email    = strtolower($this->request->getPost('email'));
        $as_email = strtolower($this->request->getPost('as_email'));
        $password = $this->request->getPost('password');

        // Check login to database directly using $db
        $Auth                      = new \App\Libraries\Auth();
        [$status, $message, $user] = $Auth->loginAs($email, $password, $as_email);

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
