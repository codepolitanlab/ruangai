<?php namespace App\Pages\ruangpanel\course\student;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course Student";
        return pageView('ruangpanel/course/student/index', $data);
    }
}
