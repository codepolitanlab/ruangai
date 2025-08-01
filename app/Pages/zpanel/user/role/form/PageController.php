<?php

namespace App\Pages\zpanel\user\role\form;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Role Form';

        return pageView('zpanel/user/role/form/index', $data);
    }
}
