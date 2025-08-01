<?php

namespace App\Pages\zpanel\quiz\student;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Quiz';

        return pageView('zpanel/quiz/student/index', $data);
    }
}
