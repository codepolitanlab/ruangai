<?php namespace App\Pages\admin\user\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "User Form";
        return pageView('admin/user/form/index', $data);
    }
}
