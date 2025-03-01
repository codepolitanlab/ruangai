<?php namespace App\Pages\ruangpanel\user\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "User Form";
        return pageView('ruangpanel/user/form/index', $data);
    }
}
