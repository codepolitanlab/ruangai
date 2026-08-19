<?php

namespace Classroom\Controllers;

use Classroom\Models\LearningResourceModel;
use Classroom\Models\MaterialModel;
use Classroom\Models\SyllabusModel;
use Heroicadmin\Controllers\AdminController;

class Material extends AdminController
{
    protected $db;
    protected $materialModel;
    protected $resourceModel;

    public function __construct()
    {
        $this->data['page_title'] = 'Manajemen Materi';
        $this->data['module']     = 'classroom';
        $this->data['submodule']  = 'syllabus';

        $this->db             = \Config\Database::connect();
        $this->materialModel = new MaterialModel();
        $this->resourceModel = new LearningResourceModel();
    }

    private function loadSyllabus(int $syllabusId): ?array
    {
        $syllabus = model(SyllabusModel::class)->find($syllabusId);
        if (! $syllabus) {
            return null;
        }

        $this->data['syllabus'] = $syllabus;
        $this->data['page_title'] = 'Materi — ' . $syllabus['name'];

        return $syllabus;
    }

    public function index($syllabusId)
    {
        $syllabus = $this->loadSyllabus((int) $syllabusId);
        if (! $syllabus) {
            return $this->notFound();
        }

        $this->data['materials'] = $this->materialModel->withResources($syllabus['id']);

        return view('Classroom\Views\material\index', $this->data);
    }

    public function data($syllabusId)
    {
        $syllabus = $this->loadSyllabus((int) $syllabusId);
        if (! $syllabus) {
            return $this->response->setJSON(['data' => []]);
        }

        $materials = $this->materialModel->withResources($syllabus['id']);

        return $this->response->setJSON(['data' => $materials]);
    }

    public function store($syllabusId)
    {
        $syllabus = $this->loadSyllabus((int) $syllabusId);
        if (! $syllabus) {
            return $this->notFound();
        }

        $data = [
            'syllabus_id'  => $syllabus['id'],
            'title'        => $this->request->getPost('title'),
            'subtitle'     => $this->request->getPost('subtitle'),
            'description'  => $this->request->getPost('description'),
            'order_seq'    => $this->materialModel->nextOrder($syllabus['id']),
            'weight'       => $this->request->getPost('weight') ?: 0,
            'scoring_type' => $this->request->getPost('scoring_type') ?: 'auto',
        ];

        if (! $this->materialModel->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->materialModel->errors()));

            return redirect()->back()->withInput();
        }

        $this->materialModel->insert($data);
        session()->setFlashdata('success_message', 'Materi berhasil ditambahkan');

        return redirect()->back();
    }

    public function update($syllabusId, $id)
    {
        $material = $this->materialModel->find($id);
        if (! $material || (int) $material['syllabus_id'] !== (int) $syllabusId) {
            session()->setFlashdata('error_message', 'Materi tidak ditemukan');

            return redirect()->back();
        }

        $data = [
            'title'        => $this->request->getPost('title'),
            'subtitle'     => $this->request->getPost('subtitle'),
            'description'  => $this->request->getPost('description'),
            'weight'       => $this->request->getPost('weight') ?: 0,
            'scoring_type' => $this->request->getPost('scoring_type') ?: $material['scoring_type'],
        ];

        if (! $this->materialModel->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->materialModel->errors()));

            return redirect()->back()->withInput();
        }

        $this->materialModel->update($id, $data);
        session()->setFlashdata('success_message', 'Materi berhasil diperbarui');

        return redirect()->back();
    }

    public function delete($syllabusId, $id)
    {
        $material = $this->materialModel->find($id);
        if (! $material || (int) $material['syllabus_id'] !== (int) $syllabusId) {
            session()->setFlashdata('error_message', 'Materi tidak ditemukan');

            return redirect()->back();
        }

        $this->materialModel->delete($id);
        session()->setFlashdata('success_message', 'Materi berhasil dihapus');

        return redirect()->back();
    }

    public function reorder($syllabusId)
    {
        $orders = $this->request->getPost('orders');
        if (is_string($orders)) {
            $orders = json_decode($orders, true);
        }
        $orders = is_array($orders) ? $orders : [];

        foreach ($orders as $position => $id) {
            $material = $this->materialModel->find($id);
            if ($material && (int) $material['syllabus_id'] === (int) $syllabusId) {
                $this->db->table('cls_materials')
                    ->where('id', $id)
                    ->update(['order_seq' => (int) $position + 1]);
            }
        }

        return $this->response->setJSON(['success' => true]);
    }

    // ==================== RESOURCE ====================

    public function storeResource($syllabusId, $materialId)
    {
        $material = $this->materialModel->find($materialId);
        if (! $material || (int) $material['syllabus_id'] !== (int) $syllabusId) {
            session()->setFlashdata('error_message', 'Materi tidak ditemukan');

            return redirect()->back();
        }

        $type = $this->request->getPost('type');
        if (! in_array($type, LearningResourceModel::TYPES, true)) {
            session()->setFlashdata('error_message', 'Tipe resource tidak valid');

            return redirect()->back();
        }

        $data = [
            'material_id'         => $materialId,
            'type'                => $type,
            'title'               => $this->request->getPost('title'),
            'content'             => LearningResourceModel::encodeContent(
                $this->buildContentPayload($type)
            ),
            'order_seq'           => $this->resourceModel->nextOrder($materialId),
            'completion_criteria' => $this->request->getPost('completion_criteria') ?: 'view',
            'is_required'         => $this->request->getPost('is_required') ? 1 : 0,
            'need_review'         => $this->request->getPost('need_review') !== null
                ? ($this->request->getPost('need_review') ? 1 : 0)
                : 1,
        ];

        if (! $this->resourceModel->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->resourceModel->errors()));

            return redirect()->back()->withInput();
        }

        $this->resourceModel->insert($data);
        session()->setFlashdata('success_message', 'Resource berhasil ditambahkan');

        return redirect()->back();
    }

    public function updateResource($syllabusId, $materialId, $id)
    {
        $resource = $this->resourceModel->find($id);
        $material = $this->materialModel->find($materialId);

        if (! $resource || ! $material || (int) $resource['material_id'] !== (int) $materialId
            || (int) $material['syllabus_id'] !== (int) $syllabusId) {
            session()->setFlashdata('error_message', 'Resource tidak ditemukan');

            return redirect()->back();
        }

        $data = [
            'type'                => $resource['type'],
            'title'               => $this->request->getPost('title'),
            'content'             => LearningResourceModel::encodeContent(
                $this->buildContentPayload($resource['type'])
            ),
            'completion_criteria' => $this->request->getPost('completion_criteria') ?: $resource['completion_criteria'],
            'is_required'         => $this->request->getPost('is_required') ? 1 : 0,
            'need_review'         => $this->request->getPost('need_review') !== null
                ? ($this->request->getPost('need_review') ? 1 : 0)
                : $resource['need_review'],
        ];

        if (! $this->resourceModel->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->resourceModel->errors()));

            return redirect()->back()->withInput();
        }

        $this->resourceModel->update($id, $data);
        session()->setFlashdata('success_message', 'Resource berhasil diperbarui');

        return redirect()->back();
    }

    public function deleteResource($syllabusId, $materialId, $id)
    {
        $resource = $this->resourceModel->find($id);
        $material = $this->materialModel->find($materialId);

        if (! $resource || ! $material || (int) $resource['material_id'] !== (int) $materialId
            || (int) $material['syllabus_id'] !== (int) $syllabusId) {
            session()->setFlashdata('error_message', 'Resource tidak ditemukan');

            return redirect()->back();
        }

        $this->resourceModel->delete($id);
        session()->setFlashdata('success_message', 'Resource berhasil dihapus');

        return redirect()->back();
    }

    public function reorderResource($syllabusId, $materialId)
    {
        $orders = $this->request->getPost('orders');
        if (is_string($orders)) {
            $orders = json_decode($orders, true);
        }
        $orders = is_array($orders) ? $orders : [];

        foreach ($orders as $position => $id) {
            $resource = $this->resourceModel->find($id);
            if ($resource && (int) $resource['material_id'] === (int) $materialId) {
                $this->db->table('cls_learning_resources')
                    ->where('id', $id)
                    ->update(['order_seq' => (int) $position + 1]);
            }
        }

        return $this->response->setJSON(['success' => true]);
    }

    /**
     * Bangun array payload JSON content resource berdasarkan tipe.
     */
    private function buildContentPayload(string $type): array
    {
        $post = $this->request->getPost();
        $payload = [];

        switch ($type) {
            case 'text':
                $payload['html']         = $post['html'] ?? '';
                $payload['instructions'] = $post['instructions'] ?? '';
                break;

            case 'video':
                $payload['url']          = $post['url'] ?? '';
                $payload['platform']     = $post['platform'] ?: 'youtube';
                $payload['duration']     = $post['duration'] ?? null;
                $payload['instructions'] = $post['instructions'] ?? '';
                break;

            case 'pdf':
                $payload['file_path']    = $post['file_path'] ?? '';
                $payload['instructions'] = $post['instructions'] ?? '';
                break;

            case 'slide':
                $payload['embed_url']    = $post['embed_url'] ?? '';
                $payload['provider']     = $post['provider'] ?? '';
                $payload['instructions'] = $post['instructions'] ?? '';
                break;

            case 'audio':
                $payload['file_path']    = $post['file_path'] ?? '';
                $payload['duration']     = $post['duration'] ?? null;
                $payload['instructions'] = $post['instructions'] ?? '';
                break;

            case 'url':
                $payload['url']          = $post['url'] ?? '';
                $payload['open_in']      = $post['open_in'] ?: 'tab';
                $payload['instructions'] = $post['instructions'] ?? '';
                break;

            case 'book_ref':
                $payload['book_title'] = $post['book_title'] ?? '';
                $payload['author']     = $post['author'] ?? '';
                $payload['chapter']    = $post['chapter'] ?? '';
                $payload['page_start'] = $post['page_start'] ?? null;
                $payload['page_end']   = $post['page_end'] ?? null;
                $payload['isbn']       = $post['isbn'] ?? '';
                $payload['instructions'] = $post['instructions'] ?? '';
                break;

            case 'quiz':
                $payload['pass_score']        = $post['pass_score'] ?: 70;
                $payload['time_limit_minutes'] = $post['time_limit_minutes'] ?: 0;
                $payload['max_attempts']       = $post['max_attempts'] ?: 1;
                $payload['instructions']       = $post['instructions'] ?? '';
                break;

            case 'submission':
                $payload['submission_type']     = $post['submission_type'] ?: 'upload';
                $payload['instructions']        = $post['instructions'] ?? '';
                $payload['deadline_offset_days'] = $post['deadline_offset_days'] ?: null;
                if ($payload['submission_type'] === 'upload') {
                    $payload['allowed_types'] = $post['allowed_types'] ?? '';
                    $payload['max_size_mb']   = $post['max_size_mb'] ?: 10;
                }
                break;

            case 'meeting':
                $payload['description']  = $post['description'] ?? '';
                $payload['duration']     = $post['duration'] ?? null;
                $payload['mode']         = $post['mode'] ?: 'offline';
                $payload['instructions'] = $post['instructions'] ?? '';
                break;
        }

        return array_filter($payload, static fn ($value) => $value !== null);
    }

    private function notFound()
    {
        session()->setFlashdata('error_message', 'Silabus tidak ditemukan');

        return redirect()->to(urlScope() . '/classroom/syllabuses');
    }
}
