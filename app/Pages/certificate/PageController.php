<?php 

namespace App\Pages\certificate;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController
{
    
    public function getData($id = null)
    {
        dd($id);
        return $this->respond([
            'status' => true,
            'message' => 'Data berhasil diambil',
        ]);
    }

}