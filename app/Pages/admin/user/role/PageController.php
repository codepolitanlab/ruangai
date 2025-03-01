<?php namespace App\Pages\ruangpanel\user\role;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "User Role";
        return pageView('ruangpanel/user/role/index', $data);
    }
}
