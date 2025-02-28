<?php namespace App\Pages\admin\setting;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Setting";
        return pageView('admin/setting/index', $data);
    }
}
