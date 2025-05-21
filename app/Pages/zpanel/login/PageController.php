<?php 

namespace App\Pages\zpanel\login;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => "Login"
    ];

    public function getIndex()
    {
        return pageView('zpanel/login/index', $this->data);
    }

    // Check login
    public function postIndex()
    {
        $username = strtolower($this->request->getPost('identity'));
        $password = $this->request->getPost('password');

        if(empty($username) || empty($password)) {
            session()->setFlashdata('message', 'Username dan Password harus diisi');
            redirectPage('zpanel/login');
        }
        
        $Auth = new \App\Libraries\AuthSSR();
        [$status, $message, $user] = $Auth->login($username, $password);

        if($status == 'failed') {
            session()->setFlashdata('message', $message);
            redirectPage('zpanel/login');
        }
        
        redirectPage('zpanel');
    }

    public function getLogout()
    {
        session()->destroy();
        redirectPage('zpanel/login');
    }

    public function getTest()
    {
        $Phpass = new \App\Libraries\Phpass();
        dd($Phpass->CheckPassword('bismillah', '$P$BLZDsvTOH.MxpmbpMSXj86LPJ8Tj4A0'));
    }
}