<?php

namespace App\Pages\courses\claim_certificate;

use App\Pages\BaseController;
use Exception;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Claim Certificate',
    ];

    public function getData($course_id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        // Check requirement
        try {
            $this->checkRequirement($jwt->user_id, $course_id);
        } catch (Exception $e) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat mengecek kelengkapan data sebelum mengambil data sertifikat: ' . $e->getMessage(),
            ]);
        }

        $student = model('CourseStudentModel')
            ->select('course_students.*, users.name')
            ->join('users', 'users.id = course_students.user_id')
            ->where('user_id', $jwt->user_id)
            ->where('course_id', $course_id)
            ->first();

        if (! $student) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat mengecek kelengkapan data sebelum mengambil data sertifikat',
            ]);
        }

        $this->data['student'] = $student;

        return $this->respond($this->data);
    }

    // Generate certificate and save feedback
    public function postIndex()
    {
        $Heroic    = new \App\Libraries\Heroic();
        $jwt       = $Heroic->checkToken();
        $post      = $this->request->getPost();
        $course_id = $post['course_id'];

        // Check field data
        if (! $post['name']) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Name is required',
            ]);
        }
        if (! $post['comment']) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Comment is required',
            ]);
        }
        if (! $post['rating']) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Rating is required',
            ]);
        }

        // Check requirement
        try {
            $this->checkRequirement($jwt->user_id, $course_id);
        } catch (Exception $e) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat mengecek kelengkapan data sebelum generate sertifikat: ' . $e->getMessage(),
            ]);
        }

        // Save feedback
        $data = [
            'user_id'     => $jwt->user_id,
            'rate'        => in_array($post['rating'], [1, 2, 3, 4, 5], true) ? $post['rating'] : 5,
            'comment'     => esc($post['comment']),
            'object_id'   => $course_id,
            'object_type' => 'course',
            'created_at'  => date('Y-m-d H:i:s'),
        ];
        model('Feedback')->insert($data);

        // Update name
        $db = \Config\Database::connect();
        $db->table('users')
            ->where('id', $jwt->user_id)
            ->update(['name' => trim($post['name'])]);

        // Create certificate record in certificates table
        $certificateModel = model('CertificateModel');
        
        // Get course data
        $course = model('Course')->find($course_id);
        
        $certificateData = [
            'user_id' => $jwt->user_id,
            'course_id' => $course_id,
            'participant_name' => trim($post['name']),
            'course_title' => $course['course_title'],
            'cert_claim_date' => date('Y-m-d H:i:s'),
            'template_name' => 'default', // Use default template for course certificates
        ];

        $certificateId = $certificateModel->createCourseCertificate($certificateData);

        // Generate token reward lulus
        $tokenFromGraduate = model('UserToken')->isExists($jwt->user_id, 'graduate');
        if (! $tokenFromGraduate) {
            model('UserToken')->generate($jwt->user_id, 'graduate');
        }
        
        if (!$certificateId) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Gagal membuat sertifikat: ' . implode(', ', $certificateModel->errors()),
            ]);
        }

        // Get the created certificate to get cert_code
        $certificate = $certificateModel->find($certificateId);

        // Update course_students with certificate_id and legacy fields for backward compatibility
        $db = \Config\Database::connect();
        $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->where('course_id', $course_id)
            ->update(['certificate_id'  => $certificateId]);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Feedback berhasil disimpan',
            'data'    => [
                'code' => $certificate['cert_code'],
                'certificate_id' => $certificateId,
            ],
        ]);
    }

     private function checkRequirement($user_id, $course_id)
    {
        // Check if user has completed the course
        $db             = \Config\Database::connect();
        $learningStatus = $db->table('course_students')
            ->where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->get()
            ->getRowArray();

        if (! $learningStatus) {
            throw new Exception('User tidak ditemukan atau sudah pernah klaim sertifikat.');
        }

        // Check if user has complete live session at least 3 times
        if ($learningStatus['progress'] < 100) {
            throw new Exception('User belum menyelesaikan belajar.');
        }

        if ($learningStatus['live_attended'] < 1) {
            $liveIsCompleted = $db->table('live_attendance')
                ->select('live_meeting_id')
                ->where('user_id', $user_id)
                ->where('course_id', $course_id)
                ->where('status', 1)
                ->where('deleted_at', null)
                ->groupBy('live_meeting_id')
                ->countAllResults();

            if ($liveIsCompleted < 1) {
                throw new Exception('User belum memenuhi ketentuan minimum mengikuti live session.');
            }
        }

        return $learningStatus['id'];
    }

    /**
     * Get existing certificate for user and course
     */
    public function getExistingCertificate($user_id, $course_id)
    {
        $certificateModel = model('CertificateModel');
        return $certificateModel
            ->where('user_id', $user_id)
            ->where('entity_type', 'course')
            ->where('entity_id', $course_id)
            ->where('is_active', 1)
            ->first();
    }

    /**
     * Check if user can claim certificate
     */
    public function canClaimCertificate($user_id, $course_id)
    {
        try {
            $this->checkRequirement($user_id, $course_id);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
