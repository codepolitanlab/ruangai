<?php

namespace App\Pages\zpanel\user\role;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'User Role';

        return pageView('zpanel/user/role/index', $data);
    }
}
