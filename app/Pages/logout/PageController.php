<?php namespace App\Pages\logout;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController 
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