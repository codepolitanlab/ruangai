<?php namespace App\Pages\courses\intro\live_session;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Live Session';
        return pageView('courses/intro/live_session/index', $data);
    }
}
