<?php

namespace Heroicadmin\Modules\Dashboard\Controllers;

use Heroicadmin\Controllers\AdminController;

class Dashboard extends AdminController
{
    public function index()
    {
        $this->data['page_title'] = 'Dashboard';

        return view('Heroicadmin\Modules\Dashboard\Views\index', $this->data);
    }
}
