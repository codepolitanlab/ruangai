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
        $EmailSender = new \App\Libraries\EmailSender();

        $to      = 'toha.samba@gmail.com';
        $subject = 'Selamat Bergabung di Komiunitas RuangAI';
        $message = 'Terima kasih terlah bergabung. Selamat kamu telah menjadi juara di RuangAI';

        $EmailSender->setTemplate('sample');
        $EmailSender->send($to, $subject, $EmailSender->getMessage(), 1);
    }

    public function checkToken($token)
    {
        $Auth   = new \App\Libraries\Auth();
        $result = $Auth->validateToken('Bearer ' . $token);

        dd($result);
    }
}
