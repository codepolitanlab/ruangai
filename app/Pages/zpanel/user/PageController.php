<?php namespace App\Pages\zpanel\user;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Users";
        return pageView('zpanel/user/index', $data);
    }
}
