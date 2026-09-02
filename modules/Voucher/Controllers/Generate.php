<?php

namespace Voucher\Controllers;

use Heroicadmin\Controllers\AdminController;

class Generate extends AdminController
{
    public $data = [
        'page_title' => 'Generate Voucher',
        'module'     => 'voucher',
        'submodule'  => 'generate',
    ];

    public function index()
    {
        $db = \Config\Database::connect();

        // Online course
        $courses = $db->table('courses')
            ->select('id, course_title, has_live_sessions')
            ->where('deleted_at', null)
            ->orderBy('course_title', 'asc')
            ->get()
            ->getResultArray();

        // Kelas bootcamp yang aktif (dari Classroom)
        $classes = $db->table('cls_classes')
            ->select('cls_classes.id, cls_classes.name, cls_syllabuses.name AS syllabus_name')
            ->join('cls_syllabuses', 'cls_syllabuses.id = cls_classes.syllabus_id', 'left')
            ->where('cls_classes.deleted_at', null)
            ->where('cls_classes.status', 'active')
            ->orderBy('cls_classes.name', 'asc')
            ->get()
            ->getResultArray();

        $this->data['courses'] = $courses;
        $this->data['classes'] = $classes;

        return view('Voucher\Views\generate\index', $this->data);
    }

    /**
     * AJAX: Ambil daftar batch untuk course tertentu.
     * GET /ruangpanel/voucher/generate/batches?course_id=X
     */
    public function batches()
    {
        $courseId = (int) $this->request->getGet('course_id');

        if (! $courseId) {
            return $this->response->setJSON([]);
        }

        $db      = \Config\Database::connect();
        $batches = $db->table('live_batch')
            ->select('id, name')
            ->where('course_id', $courseId)
            ->where('deleted_at', null)
            ->orderBy('id', 'desc')
            ->get()
            ->getResultArray();

        return $this->response->setJSON($batches);
    }

    /**
     * POST /ruangpanel/voucher/generate/store
     */
    public function store()
    {
        $db = \Config\Database::connect();

        // Tipe voucher: 'course' (online course) atau 'bootcamp' (kelas bootcamp)
        $objectType = (string) $this->request->getPost('object_type');
        $objectType = in_array($objectType, ['course', 'bootcamp'], true) ? $objectType : 'course';

        $objectId    = (int) $this->request->getPost('object_id');
        $liveBatchId = (int) $this->request->getPost('live_batch_id');
        $quantity    = max(1, min((int) ($this->request->getPost('quantity') ?: 1), 500));
        $name        = trim((string) $this->request->getPost('name')) ?: 'CODEPOLITAN';
        $email       = trim((string) $this->request->getPost('email')) ?: 'codepolitan@gmail.com';
        $phone       = trim((string) $this->request->getPost('phone')) ?: '-';

        if (! $objectId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pilih kelas terlebih dahulu.']);
        }

        // Metadata: hanya online course yang memakai batch live session
        $metadata = ['duration' => '0'];
        if ($objectType === 'course') {
            $metadata['live_batch_id'] = (string) $liveBatchId;
        }
        $metadataJson = json_encode($metadata);

        $characters  = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $codeLength  = 8;
        $maxAttempts = 10;

        $generated = [];
        $errors    = [];

        for ($i = 0; $i < $quantity; $i++) {
            // Generate kode unik
            $voucherCode = null;
            for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
                $code = '';
                for ($j = 0; $j < $codeLength; $j++) {
                    $code .= $characters[random_int(0, strlen($characters) - 1)];
                }
                $exists = $db->table('vouchers')
                    ->where('voucher_code', $code)
                    ->where('deleted_at', null)
                    ->countAllResults();
                if (! $exists) {
                    $voucherCode = $code;
                    break;
                }
            }

            if ($voucherCode === null) {
                $errors[] = "Gagal generate kode unik pada iterasi ke-{$i}.";
                continue;
            }

            $db->table('vouchers')->insert([
                'object_id'    => $objectId,
                'object_type'  => $objectType,
                'voucher_code' => $voucherCode,
                'name'         => $name,
                'email'        => $email,
                'phone'        => $phone,
                'metadata'     => $metadataJson,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);

            $generated[] = $voucherCode;
        }

        if (empty($generated)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal generate voucher: ' . implode(', ', $errors),
            ]);
        }

        return $this->response->setJSON([
            'success'   => true,
            'message'   => count($generated) . ' voucher berhasil digenerate.',
            'generated' => $generated,
            'errors'    => $errors,
        ]);
    }
}
