<?php namespace App\Pages\zpanel\course\live;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Zpanel Course Live Page"
    ];

    public function getData()
    {
        $this->data['name'] = "Oren Kohler";

        return $this->respond($this->data);
    }
}
