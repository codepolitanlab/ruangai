<?php namespace App\Pages\admin\user\role;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "User Role";
        return pageView('admin/user/role/index', $data);
    }
}
