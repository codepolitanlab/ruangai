<?php namespace App\Pages\zpanel\course\lesson\theory;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Theory";
        return pageView('zpanel/course/lesson/theory/index', $data);
    }
}
