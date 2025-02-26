<?php namespace App\Pages\admin\course\lessons\quiz;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz";
        return pageView('admin/course/lessons/quiz/index', $data);
    }
}
