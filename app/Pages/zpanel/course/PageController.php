<?php namespace App\Pages\zpanel\course;

use App\Pages\zpanel\AdminController;

class PageController extends AdminController 
{
    public $data = [
        'page_title' => "Online Class"
    ];

    public function getIndex()
    {
        $db = \Config\Database::connect();
        $this->data['courses'] = $db->table('courses')->get()->getResultArray();

        return pageView('zpanel/course/index', $this->data);
    }
}
