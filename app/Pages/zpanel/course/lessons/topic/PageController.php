<?php namespace App\Pages\zpanel\course\lessons\topic;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Theory";
        return pageView('zpanel/course/lessons/topic/index', $data);
    }
}
