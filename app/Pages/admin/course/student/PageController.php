<?php namespace App\Pages\admin\course\student;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course Student";
        return pageView('admin/course/student/index', $data);
    }
}
