<?php namespace App\Pages\prompt;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Prompts Page"
    ];

    public function getData()
    {
        $this->data['name'] = "Prof. Nayeli Corwin";

        return $this->respond($this->data);
    }
}
