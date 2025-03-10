<?php namespace App\Pages\courses\intro\student;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Student';
        return pageView('courses/intro/student/index', $data);
    }
}
