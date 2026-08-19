<?php

namespace Classroom\Controllers;

use Classroom\Models\ClassMaterialModel;
use Classroom\Models\ClassRoomModel;
use Classroom\Models\LearningResourceModel;
use Classroom\Models\SyllabusModel;
use Heroicadmin\Controllers\AdminController;

class ClassRoom extends AdminController
{
    protected $db;
    protected $model;
    protected $classMaterialModel;

    public function __construct()
    {
        $this->data['page_title'] = 'Manajemen Kelas';
        $this->data['module']     = 'classroom';
        $this->data['submodule']  = 'classes';

        $this->db                  = \Config\Database::connect();
        $this->model               = new ClassRoomModel();
        $this->classMaterialModel  = new ClassMaterialModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?: '';
        $status = $this->request->getGet('status') ?: '';

        $this->data['search'] = $search;
        $this->data['status'] = $status;
        $this->data['classes'] = $this->model->withSyllabus(array_filter([
            'c.status' => $status ?: null,
        ]), $search);

        foreach ($this->data['classes'] as &$class) {
            $class['member_count'] = $this->model->memberCount($class['id']);
        }

        return view('Classroom\Views\class\index', $this->data);
    }

    public function data()
    {
        $request = $this->request;
        $draw    = (int) $request->getPost('draw');
        $start   = (int) ($request->getPost('start') ?? 0);
        $length  = (int) ($request->getPost('length') ?? 10);
        $search  = $request->getPost('search')['value'] ?? '';
        $status  = $request->getPost('status') ?? '';

        $builder = $this->db->table('cls_classes c')
            ->select('c.*, s.name AS syllabus_name,
                      (SELECT COUNT(*) FROM cls_class_members m WHERE m.class_id = c.id AND m.status = \'active\') AS member_count')
            ->join('cls_syllabuses s', 's.id = c.syllabus_id', 'left')
            ->where('c.deleted_at IS NULL');

        if ($status) {
            $builder->where('c.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('c.name', $search)
                ->orLike('s.name', $search)
                ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $rows  = $builder->orderBy('c.created_at', 'DESC')
            ->limit($length, $start)
            ->get()->getResultArray();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'id'             => $row['id'],
                'name'           => $row['name'],
                'syllabus_name'  => $row['syllabus_name'],
                'status'         => $row['status'],
                'start_date'     => $row['start_date'] ? date('d M Y', strtotime($row['start_date'])) : '-',
                'member_count'   => $row['member_count'],
                'claimable'      => $row['certificate_claimable'],
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

    public function form($id = null)
    {
        $class = null;
        if ($id) {
            $class = $this->model->find((int) $id);
            if (! $class) {
                session()->setFlashdata('error_message', 'Kelas tidak ditemukan');

                return redirect()->to(urlScope() . '/classroom/classes');
            }
            $this->data['page_title'] = 'Edit Kelas — ' . $class['name'];
        }

        $this->data['class'] = $class;
        $this->data['syllabuses'] = $this->db->table('cls_syllabuses')
            ->select('id, name')
            ->where('status', 'published')
            ->where('deleted_at IS NULL')
            ->orderBy('name', 'ASC')
            ->get()->getResultArray();

        // Resource submission untuk checklist sertifikat (saat edit, preload dari silabus kelas)
        $this->data['certificateResources'] = [];
        if ($class) {
            $this->data['certificateResources'] = $this->db->table('cls_learning_resources r')
                ->select('r.id, r.title, m.title AS material_title')
                ->join('cls_materials m', 'm.id = r.material_id')
                ->where('r.type', 'submission')
                ->where('r.deleted_at IS NULL')
                ->where('m.syllabus_id', $class['syllabus_id'])
                ->where('m.deleted_at IS NULL')
                ->orderBy('m.order_seq', 'ASC')
                ->orderBy('r.order_seq', 'ASC')
                ->get()->getResultArray();
        }

        return view('Classroom\Views\class\form', $this->data);
    }

    /**
     * Dropdown silabus published (untuk form kelas).
     */
    public function syllabuses()
    {
        $syllabuses = $this->db->table('cls_syllabuses')
            ->select('id, name')
            ->where('status', 'published')
            ->where('deleted_at IS NULL')
            ->orderBy('name', 'ASC')
            ->get()->getResultArray();

        return $this->response->setJSON($syllabuses);
    }

    /**
     * Checklist resource tipe submission dari silabus (untuk pengaturan sertifikat).
     */
    public function resources()
    {
        $syllabusId = (int) $this->request->getGet('syllabus_id');

        if (! $syllabusId) {
            return $this->response->setJSON([]);
        }

        $resources = $this->db->table('cls_learning_resources r')
            ->select('r.id, r.title, m.title AS material_title')
            ->join('cls_materials m', 'm.id = r.material_id')
            ->where('r.type', 'submission')
            ->where('r.deleted_at IS NULL')
            ->where('m.syllabus_id', $syllabusId)
            ->where('m.deleted_at IS NULL')
            ->orderBy('m.order_seq', 'ASC')
            ->orderBy('r.order_seq', 'ASC')
            ->get()->getResultArray();

        return $this->response->setJSON($resources);
    }

    public function store()
    {
        $syllabusId = (int) $this->request->getPost('syllabus_id');

        // Hanya silabus published yang bisa dipakai kelas
        $syllabus = $this->db->table('cls_syllabuses')
            ->where('id', $syllabusId)
            ->where('status', 'published')
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        if (! $syllabus) {
            session()->setFlashdata('error_message', 'Silabus tidak valid atau belum dipublikasikan');

            return redirect()->back()->withInput();
        }

        $certRequirement = $this->request->getPost('certificate_requirement');
        $certRequirement = is_array($certRequirement)
            ? implode(',', array_map('intval', array_filter($certRequirement)))
            : ($certRequirement ?: null);

        $data = [
            'syllabus_id'      => $syllabusId,
            'name'             => $this->request->getPost('name'),
            'thumbnail'        => $this->request->getPost('thumbnail'),
            'description'      => $this->request->getPost('description'),
            'status'           => 'draft', // Kelas baru tidak bisa langsung active
            'start_date'       => $this->request->getPost('start_date') ?: null,
            'whatsapp_group_url' => $this->request->getPost('whatsapp_group_url'),
            'certificate_requirement' => $certRequirement,
            'required_feedback_before_claim_certificate' => $this->request->getPost('required_feedback_before_claim_certificate') ? 1 : 0,
            'certificate_claimable' => $this->request->getPost('certificate_claimable') ? 1 : 0,
            'created_by'       => user_id(),
        ];

        if (! $this->model->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->model->errors()));

            return redirect()->back()->withInput();
        }

        $db = $this->db;
        $db->transBegin();

        try {
            $classId = $this->model->insert($data);

            // Auto-generate ClassMaterial untuk tiap materi silabus
            $this->classMaterialModel->syncFromSyllabus($classId, $syllabusId);

            $db->transCommit();
        } catch (\Throwable $e) {
            $db->transRollback();
            session()->setFlashdata('error_message', 'Terjadi kesalahan: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }

        session()->setFlashdata('success_message', 'Kelas berhasil dibuat (status draft). Lanjutkan ke jadwal untuk mengatur materi.');

        return redirect()->to(urlScope() . '/classroom/classes/' . $classId . '/schedule');
    }

    public function update($id)
    {
        $class = $this->model->find($id);
        if (! $class) {
            session()->setFlashdata('error_message', 'Kelas tidak ditemukan');

            return redirect()->to(urlScope() . '/classroom/classes');
        }

        $certRequirement = $this->request->getPost('certificate_requirement');
        $certRequirement = is_array($certRequirement)
            ? implode(',', array_map('intval', array_filter($certRequirement)))
            : ($certRequirement ?: null);

        $data = [
            'name'             => $this->request->getPost('name'),
            'thumbnail'        => $this->request->getPost('thumbnail'),
            'description'      => $this->request->getPost('description'),
            'status'           => $this->request->getPost('status') ?: $class['status'],
            'start_date'       => $this->request->getPost('start_date') ?: null,
            'whatsapp_group_url' => $this->request->getPost('whatsapp_group_url'),
            'certificate_requirement' => $certRequirement,
            'required_feedback_before_claim_certificate' => $this->request->getPost('required_feedback_before_claim_certificate') ? 1 : 0,
            'certificate_claimable' => $this->request->getPost('certificate_claimable') ? 1 : 0,
        ];

        // Validasi aktivasi draft -> active
        if ($data['status'] === 'active' && $class['status'] !== 'active') {
            $errors = $this->activationBlockers($class['id']);
            if (! empty($errors)) {
                session()->setFlashdata('error_message', 'Kelas tidak bisa diaktifkan:<br>- ' . implode('<br>- ', $errors));

                return redirect()->back()->withInput();
            }
        }

        if (! $this->model->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->model->errors()));

            return redirect()->back()->withInput();
        }

        $this->model->update($id, $data);
        session()->setFlashdata('success_message', 'Kelas berhasil diperbarui');

        return redirect()->to(urlScope() . '/classroom/classes');
    }

    public function delete($id)
    {
        $class = $this->model->find($id);
        if (! $class) {
            session()->setFlashdata('error_message', 'Kelas tidak ditemukan');

            return redirect()->back();
        }

        if ($class['status'] === 'active') {
            session()->setFlashdata('error_message', 'Kelas active tidak bisa dihapus. Arsipkan terlebih dahulu.');

            return redirect()->back();
        }

        $this->model->delete($id);
        session()->setFlashdata('success_message', 'Kelas berhasil dihapus');

        return redirect()->to(urlScope() . '/classroom/classes');
    }

    /**
     * Blocker aktivasi kelas:
     * 1. ada materi silabus belum ter-sync ke class_materials
     * 2. ada class_materials tanpa scheduled_at
     */
    private function activationBlockers(int $classId): array
    {
        $errors = [];

        $class = $this->model->find($classId);

        // 1. Materi silabus yang belum ter-sync
        $syllabusMaterials = $this->db->table('cls_materials')
            ->where('syllabus_id', $class['syllabus_id'])
            ->where('deleted_at IS NULL')
            ->get()->getResultArray();

        $synced = $this->db->table('cls_class_materials')
            ->where('class_id', $classId)
            ->get()->getResultArray();
        $syncedIds = array_column($synced, 'material_id');

        foreach ($syllabusMaterials as $material) {
            if (! in_array($material['id'], $syncedIds, true)) {
                $errors[] = "Materi \"{$material['title']}\" belum ter-sync. Sinkronkan jadwal terlebih dahulu.";
            }
        }

        // 2. class_materials tanpa scheduled_at
        $unscheduled = $this->db->table('cls_class_materials cm')
            ->select('cm.id, m.title')
            ->join('cls_materials m', 'm.id = cm.material_id', 'left')
            ->where('cm.class_id', $classId)
            ->where('cm.scheduled_at IS NULL')
            ->get()->getResultArray();

        foreach ($unscheduled as $row) {
            $errors[] = "Materi \"{$row['title']}\" belum memiliki jadwal (scheduled_at).";
        }

        return $errors;
    }
}
