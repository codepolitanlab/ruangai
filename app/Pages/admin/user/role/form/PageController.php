<?php namespace App\Pages\ruangpanel\user\role\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Role Form";
        return pageView('ruangpanel/user/role/form/index', $data);
    }
}
