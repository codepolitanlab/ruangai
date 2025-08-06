<?php

namespace App\Pages\home;

use App\Pages\BaseController;
use Firebase\JWT\JWT;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Homepage',
        'module'      => 'homepage',
        'active_page' => 'homepage',
    ];

    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);
        $this->data['name'] = $jwt->user['name'];

        $db = \Config\Database::connect();

        $this->data['courses'] = $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->countAllResults();

        $last_lesson = $db->table('course_lesson_progress')
            ->select('
                course_lessons.lesson_title as title, 
                course_lessons.id as lesson_id, 
                course_lessons.course_id,
                course_lesson_progress.created_at as last_progress_time,
                course_students.progress,
                courses.course_title,
                courses.slug
            ')
            ->join('course_lessons', 'course_lessons.id = course_lesson_progress.lesson_id')
            ->join('course_students', 'course_students.user_id = course_lesson_progress.user_id AND course_students.course_id = course_lesson_progress.course_id')
            ->join('courses', 'courses.id = course_lesson_progress.course_id')
            ->where('course_lesson_progress.user_id', $jwt->user_id)
            ->orderBy('course_lesson_progress.created_at', 'DESC')
            ->groupBy('
                course_lessons.id, 
                course_lessons.lesson_title, 
                course_lessons.id, 
                course_lessons.course_id,
                course_lesson_progress.created_at,
                course_students.progress,
                courses.course_title,
                courses.slug')
            ->limit(1)
            ->get()
            ->getRowArray();

        if ($last_lesson) {
            $this->data['last_lesson'] = $last_lesson;
        } else {
            $this->data['last_lesson'] = (object) [
                'title' => 'Belum ada kelas',
                'lesson_id' => 1,
                'course_id' => 1,
                'last_progress_time' => 0,
                'progress' => 0,
                'course_title' => 'Dasar dan Penggunaan Generative AI',
                'slug' => 'dasar-dan-penggunaan-generative-ai',
            ];
        }

        // Get course_students
        $this->data['student'] = $db->table('course_students')
            ->select('progress, cert_claim_date, cert_code, expire_at')
            ->where('course_id', 1)
            ->where('user_id', $jwt->user_id)
            ->get()
            ->getRowArray();

        $this->data['is_expire'] = $this->data['student']['expire_at'] && $this->data['student']['expire_at'] < date('Y-m-d H:i:s') ? true : false;

        return $this->respond($this->data);
    }

    public function postSendEmailVerification()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $db = \Config\Database::connect();

        $user = $db->table('users')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        if (! $user) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'User not found',
            ]);
        }

        // set update otp_email on users
        helper('text');
        $otp    = random_string('numeric', 6);
        $update = $db->table('users')
            ->where('id', $jwt->user_id)
            ->update([
                'otp_email' => $otp,
            ]);

        if (! $update) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Failed to update OTP',
            ]);
        }

        $body = [
            'name' => $user['name'],
            'otp'  => $otp,
        ];

        $EmailSender = new \App\Libraries\EmailSender();
        $EmailSender->setTemplate('email_activation', $body);
        $EmailSender->send($user['email'], 'Email Verification');

        return $this->respond([
            'status'  => 'success',
            'message' => 'OTP has been sent to your email',
        ]);
    }

    public function postVerifyEmail()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $db = \Config\Database::connect();

        $user = $db->table('users')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        if (! $user) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'User not found',
            ]);
        }

        if ($user['otp_email'] !== $this->request->getPost('otp')) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Invalid OTP',
            ]);
        }

        $update = $db->table('users')
            ->where('id', $jwt->user_id)
            ->update([
                'email_valid' => 1,
                'otp_email'   => null,
            ]);

        $newJwt = JWT::encode([
            'email'        => strtolower($user['email']),
            'user_id'      => $user['id'],
            'isValidEmail' => 1,
            'exp'          => time() + 7 * 24 * 60 * 60,
        ], config('Heroic')->jwtKey['secret'], 'HS256');

        return $this->respond([
            'status'  => 'success',
            'message' => 'Email has been verified',
            'jwt'     => $newJwt,
        ]);
    }
}
