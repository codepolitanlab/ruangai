<?php namespace App\Pages\admin\quiz\student;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz";
        return pageView('admin/quiz/student/index', $data);
    }
}
