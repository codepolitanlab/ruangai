<?php namespace App\Pages\courses;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data = [];
        return pageView('courses/index', $data);
    }
}
