<?php

namespace Classroom\Controllers;

use Classroom\Models\ClassFeedModel;
use Classroom\Models\ClassRoomModel;
use Heroicadmin\Controllers\AdminController;

class Feed extends AdminController
{
    protected $classModel;
    protected $feedModel;

    public function __construct()
    {
        $this->data['module']    = 'classroom';
        $this->data['submodule'] = 'classes';

        $this->classModel = new ClassRoomModel();
        $this->feedModel  = new ClassFeedModel();
    }

    private function loadClass(int $classId): ?array
    {
        $class = $this->classModel->find($classId);
        if ($class) {
            $this->data['class']      = $class;
            $this->data['page_title'] = 'Pengumuman — ' . $class['name'];
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

        $this->data['feeds'] = $this->feedModel->forClass($class['id']);

        return view('Classroom\Views\feed\index', $this->data);
    }

    public function data($classId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->response->setJSON(['data' => []]);
        }

        return $this->response->setJSON([
            'data' => $this->feedModel->forClass($class['id']),
        ]);
    }

    public function store($classId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $body = trim($this->request->getPost('body') ?? '');
        if ($body === '') {
            session()->setFlashdata('error_message', 'Isi pengumuman wajib diisi');

            return redirect()->back()->withInput();
        }

        $this->feedModel->insert([
            'class_id'   => $class['id'],
            'title'      => $this->request->getPost('title') ?: null,
            'body'       => $body,
            'pinned'     => $this->request->getPost('pinned') ? 1 : 0,
            'created_by' => user_id(),
        ]);

        session()->setFlashdata('success_message', 'Pengumuman berhasil dibuat');

        return redirect()->back();
    }

    public function update($classId, $feedId)
    {
        $feed = $this->feedModel->find((int) $feedId);
        if (! $feed || (int) $feed['class_id'] !== (int) $classId) {
            session()->setFlashdata('error_message', 'Pengumuman tidak ditemukan');

            return redirect()->back();
        }

        $body = trim($this->request->getPost('body') ?? '');
        if ($body === '') {
            session()->setFlashdata('error_message', 'Isi pengumuman wajib diisi');

            return redirect()->back()->withInput();
        }

        $this->feedModel->update($feedId, [
            'title'  => $this->request->getPost('title') ?: null,
            'body'   => $body,
            'pinned' => $this->request->getPost('pinned') ? 1 : 0,
        ]);

        session()->setFlashdata('success_message', 'Pengumuman berhasil diperbarui');

        return redirect()->back();
    }

    public function delete($classId, $feedId)
    {
        $feed = $this->feedModel->find((int) $feedId);
        if (! $feed || (int) $feed['class_id'] !== (int) $classId) {
            session()->setFlashdata('error_message', 'Pengumuman tidak ditemukan');

            return redirect()->back();
        }

        $this->feedModel->delete($feedId);
        session()->setFlashdata('success_message', 'Pengumuman berhasil dihapus');

        return redirect()->back();
    }

    public function togglePin($classId, $feedId)
    {
        $feed = $this->feedModel->find((int) $feedId);
        if (! $feed || (int) $feed['class_id'] !== (int) $classId) {
            session()->setFlashdata('error_message', 'Pengumuman tidak ditemukan');

            return redirect()->back();
        }

        $this->feedModel->togglePin($feedId);
        session()->setFlashdata('success_message', 'Status pin pengumuman diperbarui');

        return redirect()->back();
    }
}
