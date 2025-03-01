<?php namespace App\Pages\zpanel\course\lessons;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Lessons";
        return pageView('zpanel/course/lessons/index', $data);
    }
}
