<?php namespace App\Pages\zpanel\course\lesson\quiz;

use App\Pages\zpanel\course\lesson\PageController as CourseLessonController;

class PageController extends CourseLessonController
{
    public $data = [
        'page_title' => "Materi"
    ];

    public function getIndex($course_id, $topic_id = null, $lesson_id = null)
    {
        $this->initBasicCourseData($course_id);

        return pageView('zpanel/course/lesson/quiz/index', $this->data);
    }
}
