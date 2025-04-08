<?php namespace App\Pages\notfound;

use App\Pages\BaseController;

class PageController extends BaseController {

    public function getIndex()
    {
        $this->data['page_title'] = 'Halaman Tidak Ditemukan';
        return pageView('offline/index', $this->data);
    }

}