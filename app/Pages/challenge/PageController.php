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
        // You can add any data processing logic here if needed

        $this->data['message'] = 'Selamat berpartisipasi di WAN Vision Clash Challenge!';
        return $this->respond($this->data);
    }
}
