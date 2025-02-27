<?php namespace App\Pages\admin\quiz\question;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz";
        return pageView('admin/quiz/question/index', $data);
    }
}
