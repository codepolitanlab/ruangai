<?php namespace App\Pages\courses;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{

    public $data = [
        'page_title' => "Daftar Kelas"
    ];
    
    public function getTemplate($params = null)
    {
        // Ambil data course dari db
        $db = \Config\Database::connect();
        $data['courses'] = [] ?? $db->table('courses')->limit(10)->orderBy('created_at', 'desc')->get()->getResultArray();
        $data['page_title'] = $this->data['page_title'];

        return pageView('courses/template', $data);
    }

}
