<?php namespace App\Pages\zpanel\user\role\privileges;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Role Privileges";
        return pageView('zpanel/user/role/privileges/index', $data);
    }
}
