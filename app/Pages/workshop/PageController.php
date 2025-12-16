<?php namespace App\Pages\workshop;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Workshop Page",
        'module'     => 'workshop',
    ];

    public function getData()
    {
        $this->data['name'] = "Yessenia Eichmann";

        return $this->respond($this->data);
    }
}
