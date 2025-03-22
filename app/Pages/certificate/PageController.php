<?php 

namespace App\Pages\certificate;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController
{
    use ResponseTrait;

    public function getContent()
    {
        $data['page_title'] = 'Certificate';

        return pageView('certificate/index', $data);
    }

    public function getSupply()
    {
        
    }

}