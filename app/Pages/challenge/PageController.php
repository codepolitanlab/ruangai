<?php namespace App\Pages\challenge;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "RuangAI Challenge - WAN Vision Clash",
        'module'     => 'challenge',
        'submodule'  => 'submit',
    ];

    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        $db = \Config\Database::connect();
        
        // Get email_valid from users table
        $user = $db->table('users')
            ->select('email_valid')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        $this->data['isValidEmail'] = $user['email_valid'] == 1 ? true : false;
        $this->data['message'] = 'Selamat berpartisipasi di WAN Vision Clash Challenge!';
        
        return $this->respond($this->data);
    }
}
