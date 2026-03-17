<?php namespace App\Pages\beasiswa\reward\howto;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Cara Mendapatkan Token Reward"
    ];

    public function getData()
    {
        return $this->respond($this->data);
    }
}
