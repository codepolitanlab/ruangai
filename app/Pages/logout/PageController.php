<?php namespace App\Pages\logout;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController 
{
    use ResponseTrait;
    
    public function getIndex()
    {
        return pageView('logout/index', $this->data);
    }

    public function getRemoveSession()
    {
        $_SESSION = [];
    }

}