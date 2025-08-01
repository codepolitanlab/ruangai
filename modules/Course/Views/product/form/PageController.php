<?php

namespace App\Pages\zpanel\course\product\form;

use App\Pages\zpanel\AdminController;

class PageController extends AdminController
{
    public $data = [
        'page_title' => 'Course Products',
        'module'     => 'products',
        'submodule'  => 'course',
    ];

    public function getIndex()
    {
        return pageView('zpanel/course/product/form/index', $this->data);
    }
}
