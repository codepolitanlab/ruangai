<?php namespace App\Pages\courses\quiz;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Quiz';
        return pageView('courses/quiz/index', $data);
    }
}
