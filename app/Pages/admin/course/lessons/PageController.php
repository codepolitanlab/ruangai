<?php namespace App\Pages\ruangpanel\course\lessons;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Lessons";
        return pageView('ruangpanel/course/lessons/index', $data);
    }
}
