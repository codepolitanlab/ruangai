<?php namespace App\Pages\pengumuman;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends BaseController {

    public $data = [
        'page_title' => 'Pengumuman',
        'module'     => 'pengumuman'
    ];

    public function getData()
    {
        return $this->respond($this->data);
    }

}