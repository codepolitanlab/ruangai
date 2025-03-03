<?php namespace App\Pages\zpanel\course\lessons\theory;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Theory";
        return pageView('zpanel/course/lessons/theory/index', $data);
    }
}
