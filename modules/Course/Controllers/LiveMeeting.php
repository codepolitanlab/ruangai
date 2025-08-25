<?php

namespace Course\Controllers;

use Heroicadmin\Controllers\AdminController;

class LiveMeeting extends AdminController
{
    public $data = [
        'page_title' => 'Live Meeting Schedule',
        'module'     => 'elearning',
        'submodule'  => 'course',
    ];
    protected $model;
    protected $batchModel;

    public function __construct()
    {
        $this->model      = model('Course\Models\LiveMeetingModel');
        $this->batchModel = model('Course\Models\LiveBatchModel');

        helper('course');
    }

    public function index($batch_id)
    {
        $this->data['meetings'] = $this->model
            ->where('live_batch_id', $batch_id)
            ->orderBy('meeting_date', 'asc')
            ->orderBy('meeting_time', 'asc')
            ->paginate(10);
        $this->data['pager'] = $this->model->pager;
        $this->data['batch'] = $this->batchModel->find($batch_id);

        return view('Course\Views\live\meeting\index', $this->data);
    }

    public function create($batch_id)
    {
        $this->data['batch'] = $this->batchModel->find($batch_id);

        return view('Course\Views\live\meeting\form', $this->data);
    }

    public function insert($batch_id)
    {
        $postData = $this->request->getPost();

        // meeting_code tidak boleh ada yang sama
        $existing = $this->model->where('meeting_code', $postData['meeting_code'])->first();
        if ($existing) {
            session()->setFlashdata('error_message', 'Meeting code sudah digunakan di meeting lain');
            return redirect()->back()->withInput();
        }

        $this->model->save($postData);
        session()->setFlashdata('success_message', 'Meeting created successfully');

        return redirect()->to(urlScope() . '/course/live/' . $postData['live_batch_id'] . '/meeting');
    }

    public function edit($batch_id, $id)
    {
        $this->data['batch']   = $this->batchModel->find($batch_id);
        $this->data['meeting'] = $this->model
            ->where('id', $id)
            ->where('live_batch_id', $batch_id)
            ->first();

        return view('Course\Views\live\meeting\form', $this->data);
    }

    public function update($batch_id, $id)
    {
        $postData = $this->request->getPost();
        $id       = $postData['id'] ?? $id;
        unset($postData['id']);

        // meeting_code tidak boleh ada yang sama
        $existing = $this->model->where('meeting_code', $postData['meeting_code'])->first();
        if ($existing) {
            session()->setFlashdata('error_message', 'Meeting code sudah digunakan di meeting lain');
            return redirect()->back()->withInput();
        }

        $this->model->update($id, $postData);
        session()->setFlashdata('success_message', 'Meeting updated successfully');

        return redirect()->to(urlScope() . '/course/live/' . $postData['live_batch_id'] . '/meeting');
    }

    public function delete($batch_id, $id)
    {
        $this->model->where('id', $id)->where('live_batch_id', $batch_id)->delete();
        session()->setFlashdata('success_message', 'Meeting deleted successfully');

        return redirect()->to(urlScope() . '/course/live/' . $batch_id . '/meeting');
    }
}
