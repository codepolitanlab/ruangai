<?php namespace App\Pages\ruangpanel\user\role\privileges;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Role Privileges";
        return pageView('ruangpanel/user/role/privileges/index', $data);
    }
}
