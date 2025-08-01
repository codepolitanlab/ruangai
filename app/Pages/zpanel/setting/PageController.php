<?php

namespace App\Pages\zpanel\setting;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Setting';

        return pageView('zpanel/setting/index', $data);
    }
}
