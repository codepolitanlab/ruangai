<?php namespace App\Pages\courses\tanya_jawab\detail;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Detail Tanya Jawab';
        return pageView('courses/tanya_jawab/detail/index', $data);
    }
}
