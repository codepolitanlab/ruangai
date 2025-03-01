<?php namespace App\Pages\ruangpanel\course\lessons\theory;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Theory";
        return pageView('ruangpanel/course/lessons/theory/index', $data);
    }
}
