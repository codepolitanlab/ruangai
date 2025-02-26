<?php namespace App\Pages\admin\course\product;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Product";
        return pageView('admin/course/product/index', $data);
    }
}
