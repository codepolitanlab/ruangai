<?php

namespace App\Pages\certificate\claim;

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
            ->where('progress', 100)
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
        $cert_code = $post['cert_code'];

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
            'rate'        => in_array($post['rating'], [1, 2, 3, 4], true) ? $post['rating'] : 4,
            'comment'     => esc($post['comment']),
            'object_id'   => $course_id,
            'object_type' => 'course',
            'created_at'  => date('Y-m-d H:i:s'),
        ];
        model('Feedback')->insert($data);

        // Update name
        $db = \Config\Database::connect();

        $db->table('certificates')
            ->where('cert_code', $cert_code)
            ->where('entity_id', $course_id)
            ->where('user_id', $jwt->user_id)
            ->update([
                'participant_name' => trim($post['name']),
                'updated_at'       => date('Y-m-d H:i:s'),
            ]);

        // Generate token reward lulus
        $tokenFromGraduate = model('UserToken')->isExists($jwt->user_id, 'graduate');
        if (! $tokenFromGraduate) {
            model('UserToken')->generate($jwt->user_id, 'graduate');
        }

        return $this->respond([
            'status'  => 'success',
            'message' => 'Feedback berhasil disimpan'
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
}
