<?php namespace App\Pages\keluar;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController 
{
    use ResponseTrait;
    
    public function getIndex()
    {
        return pageView('keluar/index', $this->data);
    }

    public function getRemoveSession()
    {
        $_SESSION = [];
    }

}