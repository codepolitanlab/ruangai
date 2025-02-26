<?php namespace App\Pages\admin\course\product\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course Product";
        return pageView('admin/course/product/form/index', $data);
    }
}
