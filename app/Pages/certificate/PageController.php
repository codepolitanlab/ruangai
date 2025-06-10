<?php 

namespace App\Pages\certificate;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController
{
    
    public function getTemplate($id = null)
    {
        // Ambil data course dari db
        $db = \Config\Database::connect();
        $this->data['certificate'] = null;

        return pageView('certificate/template', $this->data);
    }

}