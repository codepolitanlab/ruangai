<?php

namespace Course\Controllers;

use Heroicadmin\Controllers\AdminController;

class LiveBatch extends AdminController
{
    public $data = [
        'page_title' => 'Live Batches',
        'module'     => 'elearning',
        'submodule'  => 'course',
    ];

    public function index($course_id)
    {
        $CourseModel          = model('CourseModel');
        $this->data['course'] = $CourseModel->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();

        $LiveBatchModel        = model('LiveBatchModel');
        $this->data['batches'] = $LiveBatchModel->orderBy('id', 'desc')->paginate(10);
        $this->data['pager']   = $LiveBatchModel->pager;

        return view('Course\Views\live\index', $this->data);
    }

    public function create($course_id)
    {
        $CourseModel          = model('CourseModel');
        $this->data['course'] = $CourseModel->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();

        return view('Course\Views\live\form', $this->data);
    }

    public function insert($course_id)
    {
        $postData = $this->request->getPost();

        $LiveBatchModel = model('LiveBatchModel');
        $LiveBatchModel->save($postData);
        session()->set('successMsg', 'Batch created successfully.');

        return redirect()->to(urlScope() . '/course/' . $postData['course_id'] . '/live');
    }

    public function edit($course_id, $id)
    {
        $CourseModel          = model('CourseModel');
        $this->data['course'] = $CourseModel->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();

        $LiveBatchModel      = model('LiveBatchModel');
        $this->data['batch'] = $LiveBatchModel->where('id', $id)->where('course_id', $course_id)->first();

        return view('Course\Views\live\form', $this->data);
    }

    public function update($course_id, $id)
    {
        $postData = $this->request->getPost();
        $id       = $postData['id'] ?? $id;
        unset($postData['id']);

        $LiveBatchModel = model('LiveBatchModel');
        $LiveBatchModel->update($id, $postData);
        session()->set('successMsg', 'Batch updated successfully.');

        return redirect()->to(urlScope() . '/course/' . $postData['course_id'] . '/live');
    }

    public function delete($course_id, $id)
    {
        $LiveBatchModel = model('LiveBatchModel');
        $LiveBatchModel->where('id', $id)->where('course_id', $course_id)->delete();
        session()->set('successMsg', 'Batch deleted successfully.');

        return redirect()->to(urlScope() . '/course/' . $course_id . '/live');
    }
}
