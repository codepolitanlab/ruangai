<?php namespace App\Pages\admin\course\lessons\topic;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Theory";
        return pageView('admin/course/lessons/topic/index', $data);
    }
}
