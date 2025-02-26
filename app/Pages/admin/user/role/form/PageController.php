<?php namespace App\Pages\admin\user\role\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Role Form";
        return pageView('admin/user/role/form/index', $data);
    }
}
