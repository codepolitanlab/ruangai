<?php namespace App\Pages\admin;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Dashboard";
        return pageView('zpanel/index', $data);
    }
}
