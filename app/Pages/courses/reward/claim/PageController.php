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

        $user_courses = model('CourseStudent')->getUserCourses($jwt->user_id);

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

        $this->data['user_token'] = count(model('UserToken')->getAllTokenActive($jwt->user_id));

        return $this->respond($this->data);
    }

    public function postIndex()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        $course_id = $this->request->getPost('course_id');

        $tokenActive = model('UserToken')->getAllTokenActive($jwt->user_id);

        if (count($tokenActive) == 0) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kamu belum memiliki token active.'
            ]);
        }

        $checkIfClaimed = model('UserToken')->checkTokenUser($jwt->user_id, 'reward', $course_id);
        if ($checkIfClaimed) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Kamu sudah pernah klaim token reward ini.'
            ]);
        }

        // Insert to course_students
        model('CourseStudent')->insertStudent([
            'user_id'   => $jwt->user_id,
            'course_id' => $course_id,
        ]);

        // Set claimed token
        model('UserToken')->claimToken($jwt->user_id, $tokenActive[0]->id, $course_id, 'course');

        return $this->respond([
            'status'  => 'success',
            'message' => 'Token reward berhasil diklaim.'
        ]);
    }
}
