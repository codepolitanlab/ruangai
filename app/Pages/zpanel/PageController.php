<?php 

namespace App\Pages\zpanel;

class PageController extends AdminController 
{
    public function getIndex()
    {
        $this->data['page_title'] = "Dasbor";

        // dd(session()->get());

        return pageView('zpanel/index', $this->data);
    }
}
