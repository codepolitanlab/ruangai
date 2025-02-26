<?php namespace App\Pages\admin\course\lessons;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Lessons";
        return pageView('admin/course/lessons/index', $data);
    }
}
