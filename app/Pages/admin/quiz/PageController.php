<?php namespace App\Pages\admin\quiz;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz";
        return pageView('admin/quiz/index', $data);
    }
}
