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
        helper('scholarship');
        
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);
        $this->data['name'] = $jwt->user['name'];

        $db = \Config\Database::connect();
        
        // Check if user is scholarship participant
        if (! function_exists('is_scholarship_participant')) helper('scholarship');
        $this->data['is_scholarship_participant'] = \is_scholarship_participant($jwt->user_id);

        $this->data['courses'] = $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->countAllResults();

        $this->data['total_live_session'] = $db->table('live_attendance')
            ->where('user_id', $jwt->user_id)
            ->where('status', 1)
            ->countAllResults();

        $last_course = $db->table('course_lesson_progress')
            ->select('course_id as id, courses.course_title as title, courses.slug')
            ->join('courses', 'courses.id = course_lesson_progress.course_id')
            ->where('course_lesson_progress.user_id', $jwt->user_id)
            ->orderBy('course_lesson_progress.created_at', 'DESC')
            ->get()
            ->getRowArray();

        if (!$last_course) {
            $last_course = $db->table('courses')
                ->select('id, course_title as title, slug')
                ->where('id', 1)
                ->get()
                ->getRowArray();
        }

        // Get completed lessons for current user (only mandatory lessons)
        $completedLessons = $db->table('course_lessons')
            ->select('count(course_lessons.id) as total_lessons, count(course_lesson_progress.user_id) as completed')
            ->join('course_lesson_progress', 'course_lesson_progress.lesson_id = course_lessons.id AND user_id = ' . $jwt->user_id, 'left')
            ->where('course_lessons.course_id', $last_course['id'])
            ->where('course_lessons.mandatory', 1)
            ->get()
            ->getRowArray();

        $this->data['last_course']                     = $last_course;
        $this->data['last_course']['total_lessons']    = $completedLessons['total_lessons'] ?? 1;
        $this->data['last_course']['lesson_completed'] = $completedLessons['completed'] ?? 0;

        // Get course_students - safe for non-scholarship users
        $this->data['student'] = $db->table('course_students')
            ->select('progress, expire_at, scholarship_participants.program, scholarship_participants.reference, certificates.cert_claim_date, certificates.cert_code')
            ->join('scholarship_participants', 'scholarship_participants.user_id = course_students.user_id', 'left')
            ->join('certificates', 'certificates.user_id = course_students.user_id AND certificates.entity_id = course_students.course_id', 'left')
            ->where('course_students.course_id', 1)
            ->where('course_students.user_id', $jwt->user_id)
            ->get()
            ->getRowArray();

        // Safe null handling untuk user kompetisi
        $this->data['event'] = null;
        $this->data['group_comentor'] = null;
        
        if ($this->data['student'] && isset($this->data['student']['program'])) {
            $this->data['event'] = $db->table('events')
                ->select('date_start, date_end, code')
                ->where('code', $this->data['student']['program'])
                ->get()
                ->getRowArray();
        }

        $this->data['is_expire'] = ($this->data['student'] && isset($this->data['student']['expire_at']) && $this->data['student']['expire_at'] < date('Y-m-d H:i:s')) ? true : false;

        if ($this->data['student'] && isset($this->data['student']['reference'])) {
            $this->data['group_comentor'] = $db->table('shorteners')
                ->where('code', $this->data['student']['reference'])
                ->get()
                ->getRowArray();
        }

        $this->data['is_comentor'] = $jwt->user['role_id'] == 4 ? true : false;
        $this->data['scholarship_url'] = scholarship_registration_url($jwt->user_id);

        return $this->respond($this->data);
    }

    public function postSendEmailVerification()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db = \Config\Database::connect();

        $email = $this->request->getPost('email');
        if (! $email) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Email is required',
            ]);
        }

        $exists = $db->table('users')
            ->where('email', $email)
            ->where('id !=', $jwt->user_id)
            ->get()
            ->getRowArray();

        if ($exists) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Email sudah digunakan',
            ]);
        }

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
        $EmailSender->send($email, 'Email Verification');

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
        $email = $this->request->getPost('email');

        $exists = $db->table('users')
            ->where('email', $email)
            ->where('id !=', $jwt->user_id)
            ->get()
            ->getRowArray();

        if ($exists) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Email sudah digunakan',
            ]);
        }

        $user = $db->table('users')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        if ($user['otp_email'] !== $this->request->getPost('otp')) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Invalid OTP',
            ]);
        }

        $db->table('users')
            ->where('id', $jwt->user_id)
            ->update([
                'email_valid' => 1,
                'otp_email'   => null,
                'email'       => $email,
            ]);
        
        // Update scholarship_participants only if user is participant
        helper('scholarship');
        if (\is_scholarship_participant($jwt->user_id)) {
            $db->table('scholarship_participants')
                ->where('user_id', $jwt->user_id)
                ->update([
                    'email' => $email,
                ]);
        }

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
