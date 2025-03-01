<?php namespace App\Pages\zpanel\course\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course";
        return pageView('zpanel/course/form/index', $data);
    }
}
