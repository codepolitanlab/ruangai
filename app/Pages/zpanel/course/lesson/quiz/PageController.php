<?php namespace App\Pages\zpanel\course\lesson\quiz;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz";
        return pageView('zpanel/course/lesson/quiz/index', $data);
    }
}
