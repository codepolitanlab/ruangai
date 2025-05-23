<?php namespace App\Pages\zpanel\course\lesson;

use App\Pages\zpanel\AdminController;

class PageController extends AdminController 
{
    public $data = [
        'page_title' => "Daftar Materi"
    ];

    public function getIndex($course_id)
    {
        $db = \Config\Database::connect();
        $this->data['course'] = $db->table('courses')->where('id', $course_id)->get()->getRowArray();

        return pageView('zpanel/course/lesson/index', $this->data);
    }
}
