<?php

namespace Heroicadmin\Modules\User\Controllers;

use App\Pages\BaseController;

class Auth extends BaseController
{
    public $data = [
        'page_title' => 'Login',
    ];

    public function __construct()
    {
        // Load helper
        helper('Heroicadmin\Helpers\heroicadmin');
    }

    public function login()
    {
        return view('Heroicadmin\Modules\User\Views\auth\login', $this->data);
    }

    // Check login
    public function checkLogin()
    {
        $username = strtolower($this->request->getPost('identity'));
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            session()->setFlashdata('warning_message', 'Username dan Password harus diisi');

            return redirect()->back()->withInput();
        }

        $Auth                      = new \Heroicadmin\Modules\User\Libraries\Auth();
        [$status, $message, $user] = $Auth->login($username, $password);

        if ($status === 'failed') {
            session()->setFlashdata('warning_message', $message);

            return redirect()->back()->withInput();
        }

        return redirect(urlScope());
    }

    public function logout()
    {
        session()->destroy();

        return redirect(urlScope() . '/user/login');
    }
}
