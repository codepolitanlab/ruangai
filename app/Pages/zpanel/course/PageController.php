<?php namespace App\Pages\zpanel\course;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Online Class";
        return pageView('zpanel/course/index', $data);
    }
}
