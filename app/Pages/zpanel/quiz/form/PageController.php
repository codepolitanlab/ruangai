<?php

namespace App\Pages\zpanel\quiz\form;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Quiz Form';

        return pageView('zpanel/quiz/form/index', $data);
    }
}
