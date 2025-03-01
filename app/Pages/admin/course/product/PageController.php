<?php namespace App\Pages\ruangpanel\course\product;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Product";
        return pageView('ruangpanel/course/product/index', $data);
    }
}
