<?php namespace App\Pages\admin\user;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Users";
        return pageView('admin/user/index', $data);
    }
}
