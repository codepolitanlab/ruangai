<?php namespace App\Pages\pustaka;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data = [];
        return pageView('pustaka/index', $data);
    }
}
