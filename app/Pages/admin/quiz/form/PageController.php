<?php namespace App\Pages\ruangpanel\quiz\form;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Quiz Form";
        return pageView('ruangpanel/quiz/form/index', $data);
    }
}
