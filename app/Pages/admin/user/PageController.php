<?php namespace App\Pages\ruangpanel\user;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Users";
        return pageView('ruangpanel/user/index', $data);
    }
}
