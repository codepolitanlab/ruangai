<?php

namespace App\Pages\keluar;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        return pageView('keluar/index', $this->data);
    }

    public function getRemoveSession()
    {
        $_SESSION = [];
    }
}
