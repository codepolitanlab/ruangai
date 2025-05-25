<?php namespace App\Pages\zpanel\course\live\blueprint;

use App\Models\LiveMeetingBlueprintModel;
use App\Pages\zpanel\AdminController;

class PageController extends AdminController 
{
    public $data = [
        'page_title' => "Live Meeting Blueprints"
    ];

    protected $model;

    public function __construct()
    {
        $this->model = new LiveMeetingBlueprintModel();
    }

    public function getIndex($course_id)
    {
        $CourseModel = model('Course');
        $this->data['course'] = $CourseModel->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();
        $this->data['blueprints'] = $this->model->paginate(10);
        $this->data['pager'] = $this->model->pager;

        return pageView('zpanel/course/live/blueprint/index', $this->data);
    }

    public function getCreate($course_id)
    {
        $CourseModel = model('Course');
        $this->data['course'] = $CourseModel->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();

        return pageView('zpanel/course/live/blueprint/create', $this->data);
    }

    public function postCreate()
    {
        $postData = $this->request->getPost();
        $this->model->save($postData);
        session()->set('successMsg', 'Blueprint created successfully');
        return redirectPage('/zpanel/course/live/blueprint/'.$postData['course_id']);
    }

    public function getUpdate($course_id, $id)
    {
        $CourseModel = model('Course');
        $this->data['course'] = $CourseModel->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();

        $this->data['blueprint'] = $this->model->where('id', $id)->where('course_id', $course_id)->first();
        return pageView('zpanel/course/live/blueprint/create', $this->data);
    }

    public function postUpdate()
    {
        $postData = $this->request->getPost();
        $id = $postData['id'];
        unset($postData['id']);
        $this->model->update($id, $postData);
        session()->set('successMsg', 'Blueprint updated successfully');
        return redirectPage('/zpanel/course/live/blueprint/'.$postData['course_id']);
    }

    public function getDelete($course_id, $id)
    {
        $this->model->where('id', $id)->where('course_id', $course_id)->delete();
        session()->set('successMsg', 'Blueprint deleted successfully');
        return redirectPage('/zpanel/course/live/blueprint/'.$course_id);
    }
}
