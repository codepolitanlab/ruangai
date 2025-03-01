<?php namespace App\Pages\zpanel\course\student;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course Student";
        return pageView('zpanel/course/student/index', $data);
    }
}
