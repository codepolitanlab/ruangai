<?php namespace App\Pages\zpanel\course\product;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Product";
        return pageView('zpanel/course/product/index', $data);
    }
}
