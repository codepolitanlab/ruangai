<?php namespace App\Pages\courses\tanya_jawab;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        $data['page_title'] = 'Tanya Jawab';
        return pageView('courses/tanya_jawab/index', $data);
    }
}
