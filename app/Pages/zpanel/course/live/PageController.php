<?php

namespace App\Pages\Zpanel\Course\Live;

use App\Models\LiveBatchModel;
use App\Pages\zpanel\AdminController;

use function pageView;
use function redirectPage;

class PageController extends AdminController
{
    public $data = [
        'page_title' => "Live Batches"
    ];

    protected $model;

    public function __construct()
    {
        $this->model = new LiveBatchModel();
    }

    public function getIndex($course_id)
    {
        $CourseModel = model('Course');
        $this->data['course'] = $CourseModel->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();

        $this->data['batches'] = $this->model->orderBy('id', 'desc')->paginate(10);
        $this->data['pager'] = $this->model->pager;

        return pageView('zpanel/course/live/index', $this->data);
    }

    public function getCreate($course_id)
    {
        $CourseModel = model('Course');
        $this->data['course'] = $CourseModel->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();

        return pageView('zpanel/course/live/form', $this->data);
    }

    public function postCreate()
    {
        $postData = $this->request->getPost();
        $this->model->save($postData);
        session()->set('successMsg', 'Batch created successfully.');
        return redirectPage('/zpanel/course/live/'. $postData['course_id']);
    }

    public function getUpdate($course_id, $id)
    {
        $CourseModel = model('Course');
        $this->data['course'] = $CourseModel->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();

        $this->data['batch'] = $this->model->where('id', $id)->where('course_id', $course_id)->first();
        return pageView('zpanel/course/live/form', $this->data);
    }

    public function postUpdate()
    {
        $postData = $this->request->getPost();
        $id = $postData['id'];
        unset($postData['id']);
        $this->model->update($id, $postData);
        session()->set('successMsg', 'Batch updated successfully.');
        return redirectPage('/zpanel/course/live/'. $postData['course_id']);
    }

    public function getDelete($course_id, $id)
    {
        $this->model->where('id', $id)->where('course_id', $course_id)->delete();
        session()->set('successMsg', 'Batch deleted successfully.');
        return redirectPage('/zpanel/course/live/'. $course_id);
    }
}