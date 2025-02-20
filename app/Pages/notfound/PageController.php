<?php namespace App\Pages\notfound;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController {

    public function getIndex()
    {
        $this->data['page_title'] = 'Halaman Tidak Ditemukan';
        return pageView('offline/index', $this->data);
    }

}