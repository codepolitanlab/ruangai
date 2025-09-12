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

        $this->data['user_token'] = count(model('UserToken')->getAllTokenActive($jwt->user_id));

        return $this->respond($this->data);
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
