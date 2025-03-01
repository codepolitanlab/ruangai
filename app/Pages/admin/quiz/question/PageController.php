<?php namespace App\Pages\ruangpanel\quiz\question;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz";
        return pageView('ruangpanel/quiz/question/index', $data);
    }
}
