<?php

namespace App\Pages\verify_email;

use App\Pages\BaseController;
use Firebase\JWT\JWT;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Verifikasi Email',
        'module'      => 'verify_email',
        'active_page' => 'verify_email',
    ];

    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $this->data['user'] = $jwt->user;
        $this->data['email'] = $jwt->email;
        $this->data['isValidEmail'] = $jwt->isValidEmail ?? 0;

        return $this->respond($this->data);
    }

    public function postSendEmailVerification()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();
        $db = \Config\Database::connect();

        $email = $this->request->getPost('email');

        if (!$email) {
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

        if (!$user) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'User not found',
            ]);
        }

        // === RATE LIMITING: minimum 60 detik cooldown ===
        $cache = \Config\Services::cache();
        $cooldownKey = 'otp_cooldown_' . $jwt->user_id;
        $lastSent = $cache->get($cooldownKey);

        if ($lastSent !== null) {
            $elapsed = time() - $lastSent;
            if ($elapsed < 60) {
                $remaining = 60 - $elapsed;
                return $this->respond([
                    'status'  => 'failed',
                    'message' => "Mohon tunggu {$remaining} detik sebelum mengirim ulang OTP.",
                ]);
            }
        }

        // === RATE LIMITING: max 5 OTP per jam per user ===
        $hourlyKey = 'otp_hourly_' . $jwt->user_id . '_' . date('YmdH');
        $hourlyCount = (int) $cache->get($hourlyKey);
        if ($hourlyCount >= 2) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Terlalu banyak permintaan OTP. Silakan coba lagi nanti.',
            ]);
        }

        // Generate OTP
        helper('text');
        $otp = random_string('numeric', 6);
        
        $update = $db->table('users')
            ->where('id', $jwt->user_id)
            ->update([
                'otp_email' => $otp,
            ]);

        if (!$update) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Failed to update OTP',
            ]);
        }

        // Simpan timestamp pengiriman OTP ke cache
        $cache->save($cooldownKey, time(), 300);
        $cache->save($hourlyKey, $hourlyCount + 1, 3600);

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
        $jwt    = $Heroic->checkToken();

        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');
        $otp   = $this->request->getPost('otp');

        if (!$email || !$otp) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Email dan OTP tidak boleh kosong'
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

        if ($user['otp_email'] !== $otp) {
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
            'email'        => strtolower($email),
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
