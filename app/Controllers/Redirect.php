<?php

namespace App\Controllers;

class Redirect extends BaseController
{
    public function index($code)
    {
        $db = \Config\Database::connect();

        if (!$code) {
            return redirect()->to('/');
        }

        $shortener = $db->table('shorteners')
            ->where('code', $code)
            ->get()
            ->getRowArray();

        if (!$shortener) {
            return redirect()->to('/');
        }

        return redirect()->to($shortener['destination']);
    }
}
