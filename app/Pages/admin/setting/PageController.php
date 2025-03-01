<?php namespace App\Pages\ruangpanel\setting;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Setting";
        return pageView('ruangpanel/setting/index', $data);
    }
}
