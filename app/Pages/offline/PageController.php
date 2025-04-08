<?php namespace App\Pages\offline;

use App\Pages\BaseController;

class PageController extends BaseController {

    public function getIndex()
    {
        $this->data['page_title'] = 'You are Offline';
        return pageView('offline/index', $this->data);
    }

}