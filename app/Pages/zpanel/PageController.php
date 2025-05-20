<?php namespace App\Pages\zpanel;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Dashboard";
        return pageView('zpanel/template', $data);
    }
}
