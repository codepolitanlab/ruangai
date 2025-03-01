<?php namespace App\Pages\ruangpanel\course\lessons\topic;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Theory";
        return pageView('ruangpanel/course/lessons/topic/index', $data);
    }
}
