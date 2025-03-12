<?php namespace App\Pages\courses\intro\student\detail;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Tanya Jawab';
        return pageView('courses/intro/student/detail/index', $data);
    }
}
