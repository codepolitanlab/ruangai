<?php namespace App\Pages\courses;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        // Ambil data course dari db
        $db = \Config\Database::connect();
        $data['courses'] = $db->table('courses')->limit(10)->orderBy('created_at', 'desc')->get()->getResultArray();

        return pageView('courses/index', $data);
    }

}
