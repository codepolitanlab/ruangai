<?php

namespace Course\Controllers;

use Heroicadmin\Controllers\AdminController;

class Lesson extends AdminController
{
    public $data = [
        'page_title' => 'Daftar Materi',
        'module'     => 'elearning',
        'submodule'  => 'course',
    ];
    protected $CourseModel;

    public function index($course_id)
    {
        $this->initBasicCourseData($course_id);

        return view('Course\Views\lesson\index', $this->data);
    }

    protected function initBasicCourseData($course_id)
    {
        // Wajib selalu dibawa untuk suplai data header dan sidebar
        $this->CourseModel    = model('CourseModel');
        $this->data['course'] = $this->CourseModel->where('id', $course_id)->get()->getRowArray();
        $this->data['topics'] = $this->CourseModel->getTopicLessons($course_id);
    }

    public function delete($course_id, $lesson_id)
    {
        $LessonModel = model('CourseLessonModel');

        $LessonModel->delete($lesson_id);

        session()->setFlashdata('success_message', 'Lesson telah dihapus');

        return redirectPage(urlScope() . '/course/' . $course_id);
    }
}
