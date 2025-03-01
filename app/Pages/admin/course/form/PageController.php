<?php namespace App\Pages\ruangpanel\course\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course";
        return pageView('ruangpanel/course/form/index', $data);
    }
}
