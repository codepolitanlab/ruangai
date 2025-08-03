<?php namespace App\Pages\courses\zoom;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Courses Zoom Page",
        'module' => 'courses'
    ];

    public function getData($meeting_code)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $this->data['email']        = $jwt->user['email'];
        $this->data['name']         = $jwt->user['name'];
        $this->data['meeting_code'] = $meeting_code;

        // TODO: Get meeting detail
        
        // TODO: Check if user already registered and has a zoom join link 

        return $this->respond($this->data);
    }
}
