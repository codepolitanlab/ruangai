<?php

namespace App\Pages\beasiswa\intro\pdf_viewer;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Modul PDF',
        'module'      => 'misi_beasiswa',
        'active_page' => 'intro',
    ];

    public function index()
    {
        return view('beasiswa/intro/pdf_viewer/template', $this->data);
    }
}
