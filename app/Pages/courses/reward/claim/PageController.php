<?php

namespace App\Pages\courses\reward\claim;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Claim Reward',
        'module'      => 'learn',
        'active_page' => 'reward',
    ];

    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        $db = \Config\Database::connect();

        $user_courses = model('CourseStudentModel')->getUserCourses($jwt->user_id);

        $idS = [];
        foreach ($user_courses as $uc) {
            $idS[] = $uc->course_id;
        }

        $this->data['premium_courses'] = $db->table('courses')
            ->where('id !=', 1)
            ->where('deleted_at', null)
            ->whereNotIn('id', $idS)
            ->get()
            ->getResult();

        // ===== Kelas live (cls_classes) yang belum diikuti user =====
        $enrolledClassIds = array_column(
            $db->table('cls_class_members')
                ->select('class_id')
                ->where('user_id', $jwt->user_id)
                ->where('status', 'active')
                ->get()
                ->getResultArray(),
            'class_id'
        );

        $liveQuery = $db->table('cls_classes c')
            ->select('c.id, c.name, c.thumbnail, c.description, c.start_date, s.name AS syllabus_name')
            ->join('cls_syllabuses s', 's.id = c.syllabus_id', 'left')
            // Halaman ini hanya menampilkan kelas live id 1
            ->where('c.id', 1)
            ->where('c.status', 'active')
            ->where('c.deleted_at IS NULL')
            ->orderBy('c.start_date', 'DESC');

        if ($enrolledClassIds) {
            $liveQuery->whereNotIn('c.id', $enrolledClassIds);
        }

        $this->data['live_classes'] = $liveQuery->get()->getResultArray();

        $this->data['user_token'] = count(model('UserToken')->getAllTokenActive($jwt->user_id));

        return $this->respond($this->data);
    }

    /**
     * POST /courses/reward/claim/class — klaim kelas live (cls_*) dengan token reward.
     */
    public function postClass()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;
        $classId = (int) $this->request->getPost('class_id');

        if (! $classId) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kelas tidak valid.',
            ]);
        }

        $class = $db->table('cls_classes')
            ->where('id', $classId)
            ->where('status', 'active')
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $class) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kelas tidak tersedia.',
            ]);
        }

        $member = $db->table('cls_class_members')
            ->where('class_id', $classId)
            ->where('user_id', $userId)
            ->get()
            ->getRowArray();

        if ($member && $member['status'] === 'active') {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kamu sudah terdaftar di kelas ini.',
            ]);
        }

        $tokenActive = model('UserToken')->getActiveToken($userId);

        if (count($tokenActive ?? []) < 1) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kamu tidak memiliki token reward.',
            ]);
        }

        // Pakai token reward
        model('UserToken')->claimToken($userId, $tokenActive['id'], $classId, 'classroom');

        // Daftarkan ke kelas live (reaktivasi bila sebelumnya dropped)
        if ($member) {
            $db->table('cls_class_members')
                ->where('id', $member['id'])
                ->update([
                    'status'      => 'active',
                    'role'        => 'member',
                    'enrolled_at' => date('Y-m-d H:i:s'),
                ]);
        } else {
            $db->table('cls_class_members')->insert([
                'class_id'    => $classId,
                'user_id'     => $userId,
                'role'        => 'member',
                'status'      => 'active',
                'enrolled_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->respond([
            'status'  => 'success',
            'message' => 'Kelas live berhasil diklaim.',
        ]);
    }

    public function postIndex()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        $course_id = $this->request->getPost('course_id');

        $tokenActive = model('UserToken')->getActiveToken($jwt->user_id);

        if (count($tokenActive ?? []) < 1) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kamu tidak memiliki token reward.'
            ]);
        }

        // Set claimed token
        model('UserToken')->claimToken($jwt->user_id, $tokenActive['id'], $course_id, 'course');
        
        // Enroll student to course
        model('CourseStudentModel')->enrollStudent([
            'user_id'   => $jwt->user_id,
            'course_id' => $course_id,
        ]);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Token reward berhasil diklaim.'
        ]);
    }
}
