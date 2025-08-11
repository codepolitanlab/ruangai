<?php

namespace App\Pages\zpanel\course\live\schedule;

use App\Pages\zpanel\AdminController;

class PageController extends AdminController
{
    public $data = [
        'page_title' => 'Live Meeting Schedule',
    ];
    protected $model;
    protected $batchModel;

    public function __construct()
    {
        $this->model      = new \Course\Models\LiveMeetingModel();
        $this->batchModel = new \Course\Models\LiveBatchModel();
    }

    public function getIndex($batch_id)
    {
        $this->data['meetings'] = $this->model
            ->where('live_batch_id', $batch_id)
            ->orderBy('meeting_date', 'asc')
            ->orderBy('meeting_time', 'asc')
            ->paginate(10);
        $this->data['pager'] = $this->model->pager;
        $this->data['batch'] = $this->batchModel->find($batch_id);

        return pageView('zpanel/course/live/schedule/index', $this->data);
    }

    public function getCreate($batch_id)
    {
        $this->data['batch'] = $this->batchModel->find($batch_id);

        return pageView('zpanel/course/live/schedule/form', $this->data);
    }

    public function postCreate()
    {
        $postData = $this->request->getPost();
        $this->model->save($postData);
        session()->set('successMsg', 'Meeting created successfully');

        return redirectPage('/zpanel/course/live/schedule/' . $postData['live_batch_id']);
    }

    public function getUpdate($batch_id, $id)
    {
        $this->data['batch']   = $this->batchModel->find($batch_id);
        $this->data['meeting'] = $this->model
            ->where('id', $id)
            ->where('live_batch_id', $batch_id)
            ->first();

        return pageView('zpanel/course/live/schedule/form', $this->data);
    }

    public function postUpdate()
    {
        $postData = $this->request->getPost();
        $id       = $postData['id'];
        unset($postData['id']);
        $this->model->update($id, $postData);
        session()->set('successMsg', 'Meeting updated successfully');

        return redirectPage('/zpanel/course/live/schedule/' . $postData['live_batch_id']);
    }

    public function getDelete($batch_id, $id)
    {
        $this->model->where('id', $id)->where('live_batch_id', $batch_id)->delete();
        session()->set('successMsg', 'Meeting deleted successfully');

        return redirectPage('/zpanel/course/live/schedule/' . $batch_id);
    }
}
