<?php namespace App\Pages\admin\course\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course";
        return pageView('admin/course/form/index', $data);
    }
}
