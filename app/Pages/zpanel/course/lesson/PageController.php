<?php namespace App\Pages\zpanel\course\lesson;

use App\Pages\zpanel\AdminController;

class PageController extends AdminController 
{
    public $data = [
        'page_title' => "Daftar Materi"
    ];

    protected $CourseModel;

    public function getIndex($course_id)
    {
        $this->getBasicCourseData($course_id);        

        return pageView('zpanel/course/lesson/index', $this->data);
    }

    protected function initBasicCourseData($course_id)
    {
        // Wajib selalu dibawa untuk suplai data header dan sidebar
        $this->CourseModel = new \App\Models\Course();
        $this->data['course'] = $this->CourseModel->where('id', $course_id)->get()->getRowArray();
        $this->data['topics'] = $this->CourseModel->getTopicLessons($course_id);
    }
}
