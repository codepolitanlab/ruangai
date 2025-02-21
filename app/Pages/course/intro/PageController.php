<?php namespace App\Pages\course\intro;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data = [];
        return pageView('course/intro/index', $data);
    }
}
