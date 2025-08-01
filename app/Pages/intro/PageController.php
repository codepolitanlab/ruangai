<?php

namespace App\Pages\intro;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public function getContent()
    {
        return pageView('intro/index', $this->data);
    }
}
