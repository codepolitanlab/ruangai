<?php namespace App\Pages\courses\quiz;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Quiz';
        return pageView('courses/quiz/index', $data);
    }
}
