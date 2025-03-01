<?php namespace App\Pages\ruangpanel\course\product\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course Product";
        return pageView('ruangpanel/course/product/form/index', $data);
    }
}
