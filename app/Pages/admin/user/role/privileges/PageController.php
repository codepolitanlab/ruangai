<?php namespace App\Pages\admin\user\role\privileges;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Role Privileges";
        return pageView('admin/user/role/privileges/index', $data);
    }
}
