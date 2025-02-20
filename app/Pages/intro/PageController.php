<?php namespace App\Pages\intro;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController {
    
    public function getContent()
    {
        return pageView('intro/index', $this->data);
    }

}