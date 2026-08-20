<?php

namespace Classroom\Controllers;

use Classroom\Models\SyllabusModel;
use Heroicadmin\Controllers\AdminController;

class Syllabus extends AdminController
{
    protected $db;
    protected $model;

    public function __construct()
    {
        $this->data['page_title'] = 'Manajemen Silabus';
        $this->data['module']     = 'classroom';
        $this->data['submodule']  = 'syllabus';

        $this->db    = \Config\Database::connect();
        $this->model = new SyllabusModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?: '';
        $status = $this->request->getGet('status') ?: '';

        $this->data['search'] = $search;
        $this->data['status'] = $status;
        $this->data['syllabuses'] = $this->model
            ->withMaterialCount(array_filter([
                's.status' => $status ?: null,
            ]), $search);

        return view('Classroom\Views\syllabus\index', $this->data);
    }

    public function data()
    {
        $request = $this->request;
        $draw    = (int) $request->getPost('draw');
        $start   = (int) ($request->getPost('start') ?? 0);
        $length  = (int) ($request->getPost('length') ?? 10);
        $search  = $request->getPost('search')['value'] ?? '';
        $status  = $request->getPost('status') ?? '';

        $builder = $this->db->table('cls_syllabuses s')
            ->select('s.*, COUNT(m.id) AS material_count')
            ->join('cls_materials m', 'm.syllabus_id = s.id AND m.deleted_at IS NULL', 'left')
            ->where('s.deleted_at IS NULL')
            ->groupBy('s.id');

        if ($status) {
            $builder->where('s.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('s.name', $search)
                ->orLike('s.subtitle', $search)
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $rows  = $builder->orderBy('s.created_at', 'DESC')
            ->limit($length, $start)
            ->get()->getResultArray();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'id'             => $row['id'],
                'name'           => $row['name'],
                'subtitle'       => $row['subtitle'],
                'description'    => $row['description'],
                'status'         => $row['status'],
                'material_count' => $row['material_count'],
                'created_at'     => $row['created_at'] ? date('d M Y', strtotime($row['created_at'])) : '-',
            ];
        }

        return $this->response->setJSON([
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $data,
        ]);
    }

    public function store()
    {
        $data = [
            'name'        => $this->request->getPost('name'),
            'subtitle'    => $this->request->getPost('subtitle'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status') ?: 'draft',
            'created_by'  => user_id(),
        ];

        if (! $this->model->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->model->errors()));

            return redirect()->back()->withInput();
        }

        $id = $this->model->insert($data);
        session()->setFlashdata('success_message', 'Silabus berhasil dibuat');

        return redirect()->to(urlScope() . '/classroom/syllabuses/' . $id . '/materials');
    }

    public function update($id)
    {
        $syllabus = $this->model->find($id);
        if (! $syllabus) {
            session()->setFlashdata('error_message', 'Silabus tidak ditemukan');

            return redirect()->to(urlScope() . '/classroom/syllabuses');
        }

        $data = [
            'name'        => $this->request->getPost('name'),
            'subtitle'    => $this->request->getPost('subtitle'),
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status') ?: $syllabus['status'],
        ];

        // Silabus hanya bisa published jika minimal punya 1 materi
        if ($data['status'] === 'published') {
            $materialCount = $this->db->table('cls_materials')
                ->where('syllabus_id', $id)
                ->where('deleted_at IS NULL')
                ->countAllResults();

            if ($materialCount < 1) {
                session()->setFlashdata('error_message', 'Silabus hanya bisa dipublikasikan jika memiliki minimal 1 materi');

                return redirect()->back()->withInput();
            }
        }

        if (! $this->model->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->model->errors()));

            return redirect()->back()->withInput();
        }

        $this->model->update($id, $data);
        session()->setFlashdata('success_message', 'Silabus berhasil diperbarui');

        return redirect()->to(urlScope() . '/classroom/syllabuses');
    }

    public function duplicate($id)
    {
        try {
            $newId = $this->model->duplicateWithContent((int) $id);

            if (! $newId) {
                throw new \RuntimeException('Silabus tidak ditemukan');
            }

            session()->setFlashdata('success_message', 'Silabus berhasil diduplikasi (status draft)');

            return redirect()->to(urlScope() . '/classroom/syllabuses/' . $newId . '/materials');
        } catch (\Throwable $e) {
            session()->setFlashdata('error_message', 'Terjadi kesalahan: ' . $e->getMessage());

            return redirect()->back();
        }
    }

    public function delete($id)
    {
        if ($this->model->isUsedByActiveClass((int) $id)) {
            session()->setFlashdata('error_message', 'Silabus tidak bisa dihapus karena sedang dipakai oleh kelas berstatus active');

            return redirect()->back();
        }

        $this->model->delete($id);
        session()->setFlashdata('success_message', 'Silabus berhasil dihapus');

        return redirect()->to(urlScope() . '/classroom/syllabuses');
    }
}
