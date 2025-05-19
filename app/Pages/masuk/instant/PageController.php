<?php namespace App\Pages\masuk\instant;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Masuk Instant Page"
    ];

    public function postIndex()
    {
        $token = $this->request->getPost('token');
        
        $Auth = new \App\Libraries\Auth();
        [$status, $message, $user] = $Auth->instantLogin($token);   
        
        return $this->respond([
            'status' => $status,
            'message' => $message ?? '',
            'jwt' => $user['jwt'] ?? '',
        ]);
    }
}
