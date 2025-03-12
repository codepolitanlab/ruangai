<?php namespace App\Pages\courses;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        // Ambil data course dari db
        $db = \Config\Database::connect();
        $data['courses'] = $db->table('courses')->get()->getResultArray();

        return pageView('courses/index', $data);
    }

}
