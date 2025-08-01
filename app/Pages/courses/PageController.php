<?php

namespace App\Pages\courses;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Daftar Kelas',
        'module'     => 'course',
    ];

    public function getTemplate($params = null)
    {
        // Ambil data course dari db
        $db                    = \Config\Database::connect();
        $this->data['courses'] = $db->table('courses')->limit(10)->orderBy('created_at', 'desc')->get()->getResultArray() ?? [];

        return pageView('courses/template', $this->data);
    }
}
