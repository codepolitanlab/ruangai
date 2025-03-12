<?php namespace App\Pages\courses\intro\live_session\detail;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Detail Live Session';
        return pageView('courses/intro/live_session/detail/index', $data);
    }
}
