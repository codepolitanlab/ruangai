<?php namespace App\Pages\logout;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        return pageView('logout/index', $this->data);
    }

    public function getRemoveSession()
    {
        $_SESSION = [];
    }

}