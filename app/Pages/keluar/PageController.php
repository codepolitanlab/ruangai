<?php namespace App\Pages\keluar;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController 
{
    
    
    public function getIndex()
    {
        return pageView('keluar/index', $this->data);
    }

    public function getRemoveSession()
    {
        $_SESSION = [];
    }

}