<?php namespace App\Pages\ruangpanel\course\lessons\quiz;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz";
        return pageView('ruangpanel/course/lessons/quiz/index', $data);
    }
}
