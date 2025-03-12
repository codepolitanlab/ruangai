<?php namespace App\Pages\courses\intro\tanya_jawab;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Tanya Jawab Course';
        return pageView('courses/intro/tanya_jawab/index', $data);
    }
}
