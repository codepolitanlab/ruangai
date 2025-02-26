<?php namespace App\Pages\admin\quiz\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz Form";
        return pageView('admin/quiz/form/index', $data);
    }
}
