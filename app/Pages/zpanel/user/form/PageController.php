<?php namespace App\Pages\zpanel\user\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "User Form";
        return pageView('zpanel/user/form/index', $data);
    }
}
