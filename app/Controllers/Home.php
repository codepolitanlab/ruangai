<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function email()
    {
        $Heroic = new \App\Libraries\Heroic();

        $to = 'toha.samba@gmail.com';
        $subject = 'Selamat Bergabung di Komiunitas RuangAI';
        $message = 'Terima kasih terlah bergabung. Selamat kamu telah menjadi juara di RuangAI';

        $Heroic->sendEmail($to, $subject, $message, 1);
    }

    public function checkToken($token)
    {
        $Auth = new \App\Libraries\Auth();
        $result = $Auth->validateToken('Bearer ' . $token);

        dd($result);
    }
}
