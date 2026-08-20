<?php

namespace Classroom\Controllers;

use Classroom\Models\ClassMaterialModel;
use Classroom\Models\ClassMaterialResourceModel;
use Classroom\Models\ClassRoomModel;
use Classroom\Models\LearningProgressModel;
use Classroom\Models\LearningResourceModel;
use Classroom\Models\QuizQuestionModel;
use Classroom\Models\QuizResultModel;
use Classroom\Models\SubmissionModel;
use Heroicadmin\Controllers\AdminController;

class Schedule extends AdminController
{
    protected $db;
    protected $classModel;
    protected $classMaterialModel;
    protected $classMaterialResourceModel;
    protected $progressModel;
    protected $submissionModel;

    public function __construct()
    {
        $this->data['module']    = 'classroom';
        $this->data['submodule'] = 'classes';

        $this->db                            = \Config\Database::connect();
        $this->classModel                    = new ClassRoomModel();
        $this->classMaterialModel            = new ClassMaterialModel();
        $this->classMaterialResourceModel    = new ClassMaterialResourceModel();
        $this->progressModel                 = new LearningProgressModel();
        $this->submissionModel               = new SubmissionModel();
    }

    private function loadClass(int $classId): ?array
    {
        $class = $this->classModel->withSyllabus(['c.id' => $classId])[0] ?? null;
        if ($class) {
            $this->data['class']      = $class;
            $this->data['page_title'] = 'Jadwal — ' . $class['name'];
        }

        return $class;
    }

    private function notFound(string $message = 'Kelas tidak ditemukan')
    {
        session()->setFlashdata('error_message', $message);

        return redirect()->to(urlScope() . '/classroom/classes');
    }

    // ==================== INDEX / DATA ====================

    public function index($classId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $synced    = $this->classMaterialModel->forClassWithMaterials($class['id'], true);
        $all       = $this->classMaterialModel->forClassWithMaterials($class['id'], false);

        // Deteksi materi silabus yang belum ter-sync
        $syncedMaterialIds = array_column($synced, 'material_id');
        $syllabusMaterials = $this->db->table('cls_materials')
            ->where('syllabus_id', $class['syllabus_id'])
            ->where('deleted_at IS NULL')
            ->orderBy('order_seq', 'ASC')
            ->get()->getResultArray();

        $unsynced = [];
        foreach ($syllabusMaterials as $material) {
            if (! in_array($material['id'], $syncedMaterialIds, true)) {
                $material['is_unsynced'] = true;
                $unsynced[] = $material;
            }
        }

        $this->data['classMaterials'] = $synced;
        $this->data['unsyncedMaterials'] = $unsynced;

        return view('Classroom\Views\schedule\index', $this->data);
    }

    public function data($classId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->response->setJSON(['data' => []]);
        }

        return $this->response->setJSON([
            'data' => $this->classMaterialModel->forClassWithMaterials($class['id'], true),
        ]);
    }

    public function sync($classId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $created = $this->classMaterialModel->syncFromSyllabus($class['id'], $class['syllabus_id']);

        session()->setFlashdata('success_message', "Sinkronisasi selesai. {$created} materi baru ditambahkan ke jadwal.");

        return redirect()->back();
    }

    public function update($classId, $cmId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $scheduledAt = $this->request->getPost('scheduled_at');
        $this->classMaterialModel->update($cmId, [
            'scheduled_at' => $scheduledAt ? date('Y-m-d H:i:s', strtotime($scheduledAt)) : null,
            'notes'        => $this->request->getPost('notes'),
            'instructor_id' => $this->request->getPost('instructor_id') ?: null,
        ]);

        session()->setFlashdata('success_message', 'Jadwal materi berhasil diperbarui');

        return redirect()->back();
    }

    public function toggleOpen($classId, $cmId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $isOpen   = $cm['is_open'] ? 0 : 1;
        $openedAt = $isOpen ? date('Y-m-d H:i:s') : null;

        $this->classMaterialModel->update($cmId, [
            'is_open'   => $isOpen,
            'opened_at' => $openedAt,
        ]);

        session()->setFlashdata('success_message', $isOpen ? 'Materi dibuka untuk peserta' : 'Materi ditutup');

        return redirect()->back();
    }

    // ==================== DETAIL MATERI ====================

    public function detail($classId, $cmId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $data = $this->buildDetailData((int) $classId, (int) $cmId);
        if (! $data) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $this->data = array_merge($this->data, $data);
        $this->data['page_title'] = 'Detail Materi — ' . $data['cm']['material_title'];

        return view('Classroom\Views\schedule\detail', $this->data);
    }

    public function detailData($classId, $cmId)
    {
        $data = $this->buildDetailData((int) $classId, (int) $cmId);

        return $this->response->setJSON($data ?: ['error' => 'not found']);
    }

    private function buildDetailData(int $classId, int $cmId): ?array
    {
        $cm = $this->classMaterialModel->forClassWithMaterials($classId, false);
        $cm = array_values(array_filter($cm, static fn ($row) => (int) $row['id'] === $cmId))[0] ?? null;

        if (! $cm) {
            return null;
        }

        $resources = $this->db->table('cls_learning_resources')
            ->where('material_id', $cm['material_id'])
            ->where('deleted_at IS NULL')
            ->orderBy('order_seq', 'ASC')
            ->get()->getResultArray();

        foreach ($resources as &$resource) {
            $resource['content_decoded'] = LearningResourceModel::decodeContent($resource['content']);
            $resource['meeting_detail']  = $this->classMaterialResourceModel
                ->metadataFor($classId, $cm['material_id'], $resource['id']);
        }

        $cm['meeting_info_decoded'] = json_decode($cm['meeting_info'] ?? '[]', true) ?: [];

        return [
            'cm'        => $cm,
            'resources' => $resources,
        ];
    }

    // ==================== PROGRES / QUIZ / SUBMISSION ====================

    public function progress($classId, $cmId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $members = $this->db->table('cls_class_members cm')
            ->select('cm.user_id, u.name AS user_name, u.email')
            ->join('mein_users u', 'u.id = cm.user_id', 'left')
            ->where('cm.class_id', $classId)
            ->where('cm.status', 'active')
            ->get()->getResultArray();

        // Resource wajib pada materi ini
        $requiredResources = $this->db->table('cls_learning_resources')
            ->where('material_id', $cm['material_id'])
            ->where('is_required', 1)
            ->where('deleted_at IS NULL')
            ->countAllResults();

        foreach ($members as &$member) {
            $completed = $this->db->table('cls_learning_progress')
                ->where('class_material_id', $cmId)
                ->where('user_id', $member['user_id'])
                ->where('status', 'completed')
                ->countAllResults();

            $member['completed_count'] = $completed;
            $member['required_count']  = $requiredResources;
            $member['percent']         = $requiredResources > 0
                ? round(($completed / $requiredResources) * 100, 2)
                : 0;
        }

        $this->data['cm']       = $cm;
        $this->data['members']  = $members;
        $this->data['page_title'] = 'Progres Peserta';

        return view('Classroom\Views\schedule\progress', $this->data);
    }

    public function quizResults($classId, $cmId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $results = $this->db->table('cls_quiz_results qr')
            ->select('qr.*, p.user_id, p.resource_id, u.name AS user_name, r.title AS resource_title')
            ->join('cls_learning_progress p', 'p.id = qr.progress_id')
            ->join('cls_learning_resources r', 'r.id = p.resource_id', 'left')
            ->join('mein_users u', 'u.id = p.user_id', 'left')
            ->where('p.class_material_id', $cmId)
            ->orderBy('qr.submitted_at', 'DESC')
            ->get()->getResultArray();

        $this->data['cm']      = $cm;
        $this->data['results'] = $results;
        $this->data['page_title'] = 'Hasil Kuis';

        return view('Classroom\Views\schedule\quiz_results', $this->data);
    }

    public function submissions($classId, $cmId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $this->data['cm']          = $cm;
        $this->data['submissions'] = $this->submissionModel->forClassMaterial($cmId);
        $this->data['page_title']  = 'Submission Tugas';

        return view('Classroom\Views\schedule\submissions', $this->data);
    }

    // ==================== REVIEW & MEETING ====================

    public function meetingInfo($classId, $cmId)
    {
        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $resourceId = (int) $this->request->getPost('resource_id');
        if (! $resourceId) {
            return $this->notFound('Resource tidak valid');
        }

        $existing = json_decode($cm['meeting_info'] ?? '{}', true) ?: [];
        $existing["resource_{$resourceId}"] = [
            'url'      => $this->request->getPost('url'),
            'location' => $this->request->getPost('location'),
            'notes'    => $this->request->getPost('notes'),
        ];

        $this->classMaterialModel->update($cmId, [
            'meeting_info' => json_encode($existing, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ]);

        session()->setFlashdata('success_message', 'Info meeting berhasil disimpan');

        return redirect()->back();
    }

    public function reviewSubmission($classId, $cmId, $subId)
    {
        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $submission = $this->submissionModel->find((int) $subId);
        if (! $submission) {
            return $this->notFound('Submission tidak ditemukan');
        }

        $status = $this->request->getPost('status');
        if (! in_array($status, ['submitted', 'accepted', 'revision_needed'], true)) {
            session()->setFlashdata('error_message', 'Status review tidak valid');

            return redirect()->back();
        }

        $score = $this->request->getPost('review_score');
        $score = ($score === '' || $score === null) ? null : (float) $score;

        if ($status === 'accepted' && ($score === null || $score < 0 || $score > 100)) {
            session()->setFlashdata('error_message', 'Skor wajib diisi (0-100) saat submission diterima');

            return redirect()->back();
        }

        $this->submissionModel->review($subId, $status, $score, $this->request->getPost('review_note'), user_id());

        // accepted -> progress completed
        if ($status === 'accepted') {
            $progress = $this->db->table('cls_learning_progress')
                ->where('id', $submission['progress_id'])
                ->get()->getRowArray();

            if ($progress) {
                $this->progressModel->upsertStatus(
                    (int) $progress['class_material_id'],
                    (int) $progress['resource_id'],
                    (int) $progress['user_id'],
                    'completed'
                );
            }
        }

        session()->setFlashdata('success_message', 'Submission berhasil direview');

        return redirect()->back();
    }

    public function downloadSubmission($classId, $subId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $submission = $this->submissionModel->find((int) $subId);
        if (! $submission || empty($submission['file_path'])) {
            return $this->notFound('File submission tidak ditemukan');
        }

        $baseDir = realpath(ROOTPATH . 'public/uploads/submissions');
        $file    = realpath(ROOTPATH . 'public/' . ltrim($submission['file_path'], '/'));

        // Anti path traversal: file wajib berada dalam direktori submissions
        if (! $baseDir || ! $file || ! str_starts_with($file, $baseDir . DIRECTORY_SEPARATOR)
            || ! is_file($file)) {
            return $this->notFound('File tidak valid atau tidak ditemukan');
        }

        return $this->response->setHeader('Content-Type', mime_content_type($file) ?: 'application/octet-stream')
            ->setHeader('Content-Disposition', 'attachment; filename="' . basename($submission['file_name'] ?: $file) . '"')
            ->setBody(file_get_contents($file));
    }

    // ==================== MATRIKS RESOURCE / TATAP MUKA / ABSENSI ====================

    public function resourceMatrix($classId, $cmId, $resourceId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $resource = $this->db->table('cls_learning_resources')
            ->where('id', $resourceId)
            ->where('material_id', $cm['material_id'])
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        if (! $resource) {
            return $this->notFound('Resource tidak ditemukan');
        }

        $members = $this->db->table('cls_class_members cm')
            ->select('cm.user_id, u.name AS user_name, u.email')
            ->join('mein_users u', 'u.id = cm.user_id', 'left')
            ->where('cm.class_id', $classId)
            ->where('cm.status', 'active')
            ->get()->getResultArray();

        $resource['content_decoded'] = LearningResourceModel::decodeContent($resource['content']);

        foreach ($members as &$member) {
            $progress = $this->progressModel->findFor($cmId, $resourceId, $member['user_id']);
            $member['progress'] = $progress ?: ['status' => 'not_started'];

            // Kuis -> hasil terakhir
            if ($resource['type'] === 'quiz' && $progress) {
                $member['quiz_result'] = $this->db->table('cls_quiz_results')
                    ->where('progress_id', $progress['id'])
                    ->orderBy('attempt_number', 'DESC')
                    ->get()->getRowArray();
            }

            // Submission -> detail review
            if ($resource['type'] === 'submission' && $progress) {
                $member['submission'] = $this->submissionModel->forProgress($progress['id']);
            }

            // Meeting -> metadata tatap muka
            if ($resource['type'] === 'meeting') {
                $member['meeting_detail'] = $this->classMaterialResourceModel
                    ->metadataFor($classId, $cm['material_id'], $resourceId);
            }
        }

        $this->data['cm']       = $cm;
        $this->data['resource'] = $resource;
        $this->data['members']  = $members;
        $this->data['page_title'] = 'Matriks ' . $resource['title'];

        return view('Classroom\Views\schedule\resource_matrix', $this->data);
    }

    public function meetingDetail($classId, $cmId, $resourceId)
    {
        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $this->classMaterialResourceModel->upsertMetadata($classId, $cm['material_id'], $resourceId, [
            'instructor_name' => $this->request->getPost('instructor_name'),
            'zoom_link'       => $this->request->getPost('zoom_link'),
            'venue'           => $this->request->getPost('venue'),
            'mode'            => $this->request->getPost('mode') ?: 'online',
            'recording_url'   => $this->request->getPost('recording_url'),
            'password'        => $this->request->getPost('password'),
        ]);

        session()->setFlashdata('success_message', 'Detail tatap muka berhasil disimpan');

        return redirect()->back();
    }

    public function setAttendance($classId, $cmId, $resourceId)
    {
        $cm = $this->classMaterialModel->find((int) $cmId);
        if (! $cm || (int) $cm['class_id'] !== (int) $classId) {
            return $this->notFound('Materi kelas tidak ditemukan');
        }

        $userId = (int) $this->request->getPost('user_id');
        $status = $this->request->getPost('status') ?: 'not_started';

        if (! in_array($status, ['not_started', 'completed'], true)) {
            session()->setFlashdata('error_message', 'Status absensi tidak valid');

            return redirect()->back();
        }

        $this->progressModel->upsertStatus($cmId, $resourceId, $userId, $status, [
            'attended_by' => user_id(),
            'attended_at' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('success_message', 'Absensi berhasil disimpan');

        return redirect()->back();
    }
}
