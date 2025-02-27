<?php namespace App\Pages\courses\lessons;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Detail Lessons';
        return pageView('courses/lessons/index', $data);
    }
}
