<?php namespace App\Pages\admin\course;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Online Class";
        return pageView('admin/course/index', $data);
    }
}
