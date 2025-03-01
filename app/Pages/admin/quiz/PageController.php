<?php namespace App\Pages\ruangpanel\quiz;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz";
        return pageView('ruangpanel/quiz/index', $data);
    }
}
