<?php

namespace Classroom\Controllers;

use Classroom\Models\ClassRoomModel;
use Classroom\Models\FeedbackModel;
use Heroicadmin\Controllers\AdminController;

class Feedback extends AdminController
{
    protected $classModel;
    protected $feedbackModel;

    public function __construct()
    {
        $this->data['module']    = 'classroom';
        $this->data['submodule'] = 'classes';

        $this->classModel   = new ClassRoomModel();
        $this->feedbackModel = new FeedbackModel();
    }

    private function loadClass(int $classId): ?array
    {
        $class = $this->classModel->find($classId);
        if ($class) {
            $this->data['class']      = $class;
            $this->data['page_title'] = 'Feedback Peserta — ' . $class['name'];
        }

        return $class;
    }

    private function notFound(string $message = 'Kelas tidak ditemukan')
    {
        session()->setFlashdata('error_message', $message);

        return redirect()->to(urlScope() . '/classroom/classes');
    }

    public function index($classId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $this->data['feedbacks'] = $this->feedbackModel->forClassWithUsers($class['id']);
        $this->data['condition_labels'] = FeedbackModel::CONDITION_BEFORE_LABELS;

        return view('Classroom\Views\feedback\index', $this->data);
    }

    public function data($classId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->response->setJSON(['data' => []]);
        }

        return $this->response->setJSON([
            'data' => $this->feedbackModel->forClassWithUsers($class['id']),
        ]);
    }
}
