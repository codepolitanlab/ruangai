<?php namespace App\Pages\courses\intro;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Detail Kelas';
        return pageView('courses/intro/index', $data);
    }
}
