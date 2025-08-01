<?php

namespace App\Pages\zpanel\course\product\form;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Course Product';

        return pageView('zpanel/course/product/form/index', $data);
    }
}
