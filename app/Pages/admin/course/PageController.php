<?php namespace App\Pages\ruangpanel\course;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Online Class";
        return pageView('ruangpanel/course/index', $data);
    }
}
