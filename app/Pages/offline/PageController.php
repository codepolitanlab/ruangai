<?php namespace App\Pages\offline;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController {

    public function getIndex()
    {
        $this->data['page_title'] = 'You are Offline';
        return pageView('offline/index', $this->data);
    }

}