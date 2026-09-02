<?php

namespace App\Pages\bootcamp\learn;

use App\Pages\BaseController;
use Classroom\Models\LearningProgressModel;
use Classroom\Models\LearningResourceModel;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Belajar Bootcamp',
        'module'     => 'bootcamp',
        'active_page' => 'bootcamp',
        'body_class' => 'rd-dashboard-page',
    ];

    /**
     * GET /bootcamp/learn/data/{class_id} — data lengkap halaman belajar (4 tab).
     */
    public function getData($classId)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;
        $classId = (int) $classId;

        $class = $db->table('cls_classes')
            ->where('id', $classId)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $class) {
            return $this->respondSecure(['status' => 'error', 'message' => 'Kelas tidak ditemukan.'], 404);
        }

        if (! $this->isMember($db, $classId, $userId)) {
            return $this->respondSecure(['status' => 'error', 'message' => 'Anda belum terdaftar di kelas ini.'], 403);
        }

        // Cast flag boolean agar aman dipakai di JS (MySQLi mengembalikan string)
        $class['certificate_claimable']                 = (int) ($class['certificate_claimable'] ?? 0);
        $class['required_feedback_before_claim_certificate'] = (int) ($class['required_feedback_before_claim_certificate'] ?? 0);

        $syllabus = $db->table('cls_syllabuses')
            ->where('id', $class['syllabus_id'])
            ->get()
            ->getRowArray();

        // Tab Info — feed + grup WA
        $feeds = $db->table('cls_class_feeds')
            ->where('class_id', $classId)
            ->orderBy('pinned', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($feeds as &$feed) {
            $feed['pinned'] = (int) $feed['pinned'];
        }
        unset($feed);

        // Tab Materi — materi + resource + progres user
        $materials = $this->buildMaterials($db, $classId, $userId);

        // Tab Member — peserta
        $members = $db->table('cls_class_members cm')
            ->select('cm.*, u.name AS user_name, u.email, u.avatar')
            ->join('users u', 'u.id = cm.user_id', 'left')
            ->where('cm.class_id', $classId)
            ->where('cm.status', 'active')
            ->orderBy('cm.role', 'DESC')
            ->orderBy('u.name', 'ASC')
            ->get()
            ->getResultArray();

        // Tab Sertifikat
        $certificates = $db->table('certificates')
            ->where('user_id', $userId)
            ->where('entity_type', 'bootcamp')
            ->where('entity_id', $classId)
            ->where('is_active', 1)
            ->orderBy('cert_claim_date', 'DESC')
            ->get()
            ->getResultArray();

        $feedback = $db->table('cls_feedbacks')
            ->where('class_id', $classId)
            ->where('user_id', $userId)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        $canClaim = $this->canClaim($db, $class, $materials, $userId);

        $this->data['class']         = $class;
        $this->data['syllabus']      = $syllabus ?: null;
        $this->data['feeds']         = $feeds;
        $this->data['materials']     = $materials;
        $this->data['members']       = $members;
        $this->data['certificates']  = $certificates;
        $this->data['feedback']      = $feedback;
        $this->data['can_claim']     = $canClaim;
        $this->data['is_instructor'] = $this->isInstructor($db, $classId, $userId);

        return $this->respondSecure($this->data);
    }

    /**
     * POST /bootcamp/learn/progress/{cm_id}/{resource_id} — tandai resource selesai.
     */
    public function postProgress($cmId, $rid)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        $cm = $db->table('cls_class_materials')
            ->where('id', (int) $cmId)
            ->get()
            ->getRowArray();

        if (! $cm || ! $this->isMember($db, (int) $cm['class_id'], $userId)) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Akses ditolak.']);
        }

        $res = $db->table('cls_learning_resources')
            ->where('id', (int) $rid)
            ->where('material_id', $cm['material_id'])
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $res) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Resource tidak ditemukan.']);
        }

        // Kriteria selesai: submit/score_pass tidak langsung completed via tombol paham
        $status = 'completed';
        if (in_array($res['completion_criteria'], ['submit', 'score_pass'], true)) {
            $status = 'in_progress';
        }

        (new LearningProgressModel())->upsertStatus((int) $cmId, (int) $rid, $userId, $status);

        return $this->respondSecure([
            'status'   => 'success',
            'message'  => 'Progres disimpan.',
            'progress' => $status,
        ]);
    }

    /**
     * POST /bootcamp/learn/submit/{cm_id}/{resource_id} — kumpulkan tugas (file/URL).
     */
    public function postSubmit($cmId, $rid)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        $cm = $db->table('cls_class_materials')
            ->where('id', (int) $cmId)
            ->get()
            ->getRowArray();

        if (! $cm || ! $this->isMember($db, (int) $cm['class_id'], $userId)) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Akses ditolak.']);
        }

        $res = $db->table('cls_learning_resources')
            ->where('id', (int) $rid)
            ->where('material_id', $cm['material_id'])
            ->where('type', 'submission')
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $res) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Tugas tidak ditemukan.']);
        }

        $content   = LearningResourceModel::decodeContent($res['content']);
        $subType   = $content['submission_type'] ?? 'upload';
        $needReview = (int) ($res['need_review'] ?? 1) === 1;

        // Pastikan progress row ada
        $progressModel = new LearningProgressModel();
        $progress      = $progressModel->findFor((int) $cmId, (int) $rid, $userId);

        if (! $progress) {
            $progressModel->upsertStatus((int) $cmId, (int) $rid, $userId, 'in_progress');
            $progress = $progressModel->findFor((int) $cmId, (int) $rid, $userId);
        }

        // Blok re-upload jika sudah diterima
        $existingSub = $db->table('cls_submissions')
            ->where('progress_id', $progress['id'])
            ->orderBy('submitted_at', 'DESC')
            ->get()
            ->getRowArray();

        if ($existingSub && $existingSub['status'] === 'accepted') {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Tugas sudah diterima, tidak bisa diubah lagi.']);
        }

        $data = [
            'progress_id' => $progress['id'],
            'status'      => $needReview ? 'submitted' : 'accepted',
        ];

        if ($subType === 'url') {
            $url = trim((string) $this->request->getPost('url'));

            if ($url === '' || ! filter_var($url, FILTER_VALIDATE_URL) || ! preg_match('#^https?://#i', $url)) {
                return $this->respondSecure(['status' => 'failed', 'message' => 'URL tidak valid.']);
            }

            $data['type'] = 'url';
            $data['url']  = esc($url);
        } else {
            $file = $this->request->getFile('file');

            if (! $file || ! $file->isValid() || $file->hasMoved()) {
                return $this->respondSecure(['status' => 'failed', 'message' => 'File tidak valid.']);
            }

            $maxMb = (float) ($content['max_size_mb'] ?? 10);
            if ($file->getSize() > $maxMb * 1024 * 1024) {
                return $this->respondSecure(['status' => 'failed', 'message' => 'Ukuran file melebihi ' . $maxMb . ' MB.']);
            }

            $ext       = strtolower($file->getExtension());
            $blacklist = ['php', 'phar', 'sh', 'exe', 'phtml', 'pht', 'php3', 'php4', 'php5', 'php7', 'phps', 'cgi', 'pl', 'py', 'asp', 'aspx', 'jsp'];
            if (in_array($ext, $blacklist, true)) {
                return $this->respondSecure(['status' => 'failed', 'message' => 'Ekstensi file tidak diizinkan.']);
            }

            $allowedRaw = $content['allowed_types'] ?? 'pdf,zip,docx,doc,jpg,jpeg,png';
            $allowed    = array_values(array_filter(array_map('trim', explode(',', strtolower((string) $allowedRaw)))));
            if ($allowed && ! in_array($ext, $allowed, true)) {
                return $this->respondSecure(['status' => 'failed', 'message' => 'Tipe file harus: ' . implode(', ', $allowed) . '.']);
            }

            $classId    = (int) $cm['class_id'];
            $uploadPath = FCPATH . 'uploads/submissions/' . $classId;

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $fileName = $cmId . '_' . $userId . '.' . $ext;
            $file->move($uploadPath, $fileName, true);

            $data['type']      = 'file';
            $data['file_path'] = 'uploads/submissions/' . $classId . '/' . $fileName;
            $data['file_name'] = $file->getName();
            $data['file_size'] = $file->getSize();
        }

        $db->table('cls_submissions')->insert($data);

        $progressStatus = $needReview ? 'in_progress' : 'completed';
        $progressModel->upsertStatus((int) $cmId, (int) $rid, $userId, $progressStatus);

        return $this->respondSecure([
            'status'            => 'success',
            'message'           => $needReview ? 'Tugas berhasil dikumpulkan, menunggu review instruktur.' : 'Tugas diterima.',
            'submission_status' => $data['status'],
            'progress'          => $progressStatus,
        ]);
    }

    /**
     * POST /bootcamp/learn/feedback/{class_id} — simpan feedback peserta (9 pertanyaan).
     */
    public function postFeedback($classId)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;
        $classId = (int) $classId;

        $class = $db->table('cls_classes')
            ->where('id', $classId)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $class || ! $this->isMember($db, $classId, $userId)) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Akses ditolak.']);
        }

        $post = $this->request->getPost();
        $required = ['profession', 'city', 'condition_before', 'reason_choice', 'favorite_moment', 'rating', 'concrete_skill', 'message_to_friend'];

        foreach ($required as $field) {
            $val = $this->request->getPost($field);
            if ($val === null || trim((string) $val) === '') {
                return $this->respondSecure(['status' => 'failed', 'message' => 'Mohon lengkapi semua pertanyaan feedback.']);
            }
        }

        $data = [
            'class_id'              => $classId,
            'user_id'               => $userId,
            'profession'            => esc((string) $post['profession']),
            'city'                  => esc((string) $post['city']),
            'condition_before'      => in_array($post['condition_before'], ['a', 'b', 'c', 'd', 'e', 'f'], true) ? $post['condition_before'] : 'f',
            'condition_before_other' => esc((string) ($post['condition_before_other'] ?? '')),
            'reason_choice'         => esc((string) $post['reason_choice']),
            'favorite_moment'       => esc((string) $post['favorite_moment']),
            'rating'                => in_array((int) $post['rating'], [1, 2, 3, 4, 5], true) ? (int) $post['rating'] : 5,
            'concrete_skill'        => esc((string) $post['concrete_skill']),
            'message_to_friend'     => esc((string) $post['message_to_friend']),
            'allow_testimonial'     => in_array($post['allow_testimonial'] ?? 0, ['1', 'true', 'on', 1], true) ? 1 : 0,
        ];

        $existing = $db->table('cls_feedbacks')
            ->where('class_id', $classId)
            ->where('user_id', $userId)
            ->get()
            ->getRowArray();

        if ($existing) {
            $db->table('cls_feedbacks')->where('id', $existing['id'])->update($data);
        } else {
            $db->table('cls_feedbacks')->insert($data);
        }

        return $this->respondSecure([
            'status'  => 'success',
            'message' => 'Terima kasih! Feedback berhasil disimpan.',
        ]);
    }

    /**
     * POST /bootcamp/learn/claim/{class_id} — klaim sertifikat bootcamp.
     */
    public function postClaim($classId)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;
        $classId = (int) $classId;

        $class = $db->table('cls_classes')
            ->where('id', $classId)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $class || ! $this->isMember($db, $classId, $userId)) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Akses ditolak.']);
        }

        $hasCert = $db->table('certificates')
            ->where('user_id', $userId)
            ->where('entity_type', 'bootcamp')
            ->where('entity_id', $classId)
            ->where('is_active', 1)
            ->countAllResults();

        if ($hasCert > 0) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Sertifikat sudah pernah diklaim.']);
        }

        $materials = $this->buildMaterials($db, $classId, $userId);
        $check     = $this->canClaim($db, $class, $materials, $userId);

        if (! $check['allowed']) {
            return $this->respondSecure(['status' => 'failed', 'message' => $check['reason']]);
        }

        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();

        $certificateModel = model('CertificateModel');
        $certId           = $certificateModel->createCertificate([
            'user_id'          => $userId,
            'entity_type'      => 'bootcamp',
            'entity_id'        => $classId,
            'participant_name' => $user['name'] ?? 'Peserta',
            'title'            => $class['name'] ?? 'Bootcamp',
            'template_name'    => 'bootcamp',
            'cert_claim_date'  => date('Y-m-d H:i:s'),
            'additional_data'  => [
                'syllabus_name' => $class['name'],
                'claim_date'    => date('Y-m-d H:i:s'),
            ],
        ]);

        return $this->respondSecure([
            'status'  => 'success',
            'message' => 'Selamat! Sertifikat berhasil diklaim.',
            'cert_id' => $certId,
        ]);
    }

    // =====================================================================
    // Helpers
    // =====================================================================

    private function isMember($db, int $classId, int $userId): bool
    {
        return $db->table('cls_class_members')
            ->where('class_id', $classId)
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->countAllResults() > 0;
    }

    private function isInstructor($db, int $classId, int $userId): bool
    {
        $row = $db->table('cls_class_members')
            ->where('class_id', $classId)
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->get()
            ->getRowArray();

        return $row && $row['role'] === 'instructor';
    }

    /**
     * Bangun daftar materi kelas + resource + status progres user.
     */
    private function buildMaterials($db, int $classId, int $userId): array
    {
        $cms = $db->table('cls_class_materials cm')
            ->select('cm.*, m.title AS material_title, m.subtitle AS material_subtitle, m.description AS material_description, m.order_seq AS material_order_seq')
            ->join('cls_materials m', 'm.id = cm.material_id', 'left')
            ->where('cm.class_id', $classId)
            ->orderBy('m.order_seq', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($cms as &$cm) {
            // MySQLi mengembalikan TINYINT sebagai string — cast agar logika JS benar
            $cm['is_open'] = (int) $cm['is_open'];

            $resources = $db->table('cls_learning_resources r')
                ->select('r.*')
                ->where('r.material_id', $cm['material_id'])
                ->where('r.deleted_at IS NULL')
                ->orderBy('r.order_seq', 'ASC')
                ->get()
                ->getResultArray();

            $requiredCount  = 0;
            $completedCount = 0;

            foreach ($resources as &$res) {
                $res['content']      = LearningResourceModel::decodeContent($res['content']);
                $res['is_required']  = (int) $res['is_required'];
                $res['need_review']  = (int) $res['need_review'];

                $progress        = $db->table('cls_learning_progress')
                    ->where('class_material_id', $cm['id'])
                    ->where('resource_id', $res['id'])
                    ->where('user_id', $userId)
                    ->get()
                    ->getRowArray();

                $res['progress'] = $progress ? $progress['status'] : 'not_started';
                $res['submission'] = null;

                if ($res['type'] === 'submission') {
                    $sub = $db->table('cls_submissions s')
                        ->join('cls_learning_progress p', 'p.id = s.progress_id')
                        ->where('p.class_material_id', $cm['id'])
                        ->where('p.resource_id', $res['id'])
                        ->where('p.user_id', $userId)
                        ->orderBy('s.submitted_at', 'DESC')
                        ->get()
                        ->getRowArray();

                    $res['submission'] = $sub;
                }

                if ((int) $res['is_required'] === 1) {
                    $requiredCount++;
                    if ($progress && $progress['status'] === 'completed') {
                        $completedCount++;
                    }
                }
            }
            unset($res);

            $cm['resources']       = $resources;
            $cm['required_count']  = $requiredCount;
            $cm['completed_count'] = $completedCount;
            $cm['progress_percent'] = $requiredCount > 0 ? (int) round(($completedCount / $requiredCount) * 100) : 0;
        }
        unset($cm);

        return $cms;
    }

    /**
     * Cek kelayakan klaim sertifikat sesuai aturan kelas.
     */
    private function canClaim($db, array $class, array $materials, int $userId): array
    {
        $result = ['allowed' => false, 'reason' => '', 'requirements' => []];

        // 1. Gate utama
        if ((int) ($class['certificate_claimable'] ?? 0) !== 1) {
            $result['reason'] = 'Klaim sertifikat belum dibuka oleh instruktur.';

            return $result;
        }

        // 2. Tugas wajib (certificate_requirement = CSV id resource)
        $requiredIds = array_values(array_filter(array_map('trim', explode(',', (string) ($class['certificate_requirement'] ?? '')))));
        $reqDetails  = [];

        foreach ($requiredIds as $rid) {
            $resource = $db->table('cls_learning_resources')
                ->where('id', (int) $rid)
                ->get()
                ->getRowArray();

            $progress = $db->table('cls_learning_progress p')
                ->join('cls_class_materials cm', 'cm.id = p.class_material_id')
                ->where('cm.class_id', $class['id'])
                ->where('p.resource_id', (int) $rid)
                ->where('p.user_id', $userId)
                ->get()
                ->getRowArray();

            $done = $progress && $progress['status'] === 'completed';

            $reqDetails[] = [
                'resource_id' => (int) $rid,
                'title'       => $resource['title'] ?? ('Tugas #' . $rid),
                'done'        => $done,
            ];
        }

        $result['requirements'] = $reqDetails;

        foreach ($reqDetails as $req) {
            if (! $req['done']) {
                $result['reason'] = 'Masih ada tugas wajib yang belum selesai.';

                return $result;
            }
        }

        // 3. Wajib feedback
        if ((int) ($class['required_feedback_before_claim_certificate'] ?? 0) === 1) {
            $hasFeedback = $db->table('cls_feedbacks')
                ->where('class_id', $class['id'])
                ->where('user_id', $userId)
                ->where('deleted_at IS NULL')
                ->countAllResults() > 0;

            if (! $hasFeedback) {
                $result['reason'] = 'Wajib mengisi feedback sebelum klaim sertifikat.';

                return $result;
            }
        }

        // 4. Belum punya sertifikat
        $hasCert = $db->table('certificates')
            ->where('user_id', $userId)
            ->where('entity_type', 'bootcamp')
            ->where('entity_id', $class['id'])
            ->where('is_active', 1)
            ->countAllResults() > 0;

        if ($hasCert) {
            $result['reason'] = 'Sertifikat sudah pernah diklaim.';

            return $result;
        }

        $result['allowed'] = true;

        return $result;
    }
}
