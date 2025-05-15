<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\OtpWhatsappModel;
use App\Models\UserModel;
use App\Libraries\Heroic;
use App\Models\OtpRequests;
use Firebase\JWT\JWT;

class AuthController extends ResourceController
{
    protected $format = 'json';
    protected $heroic;

    public function __construct()
    {
        $this->heroic = new Heroic();
        helper(['text', 'date']);
    }

    public function sendOtp()
    {
        $number = $this->request->getPost('whatsapp_number');
        if (!$number) {
            return $this->failValidationErrors(['whatsapp_number' => 'Nomor WhatsApp harus diisi.']);
        }

        $model = new OtpWhatsappModel();

        // Rate limit (60 detik)
        $lastOtp = $model->where('whatsapp_number', $number)->orderBy('id', 'DESC')->first();
        if ($lastOtp && strtotime($lastOtp['created_at']) > time() - 60) {
            return $this->fail('OTP sudah dikirim. Silakan tunggu 60 detik.');
        }

        $otpCode = random_int(100000, 999999);
        $expiredAt = date('Y-m-d H:i:s', time() + 60);

        $model->insert([
            'otp_code' => $otpCode,
            'whatsapp_number' => $number,
            'expired_at' => $expiredAt,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Kirim via WhatsApp
        $message = "Terima kasih telah menggunakan aplikasi RuangAI.\n\nUntuk melanjutkan proses login atau pendaftaran, silakan masukkan kode verifikasi berikut ini ke dalam aplikasi:\n\n*$otpCode*\n\nSalam,";
        $this->heroic->sendWhatsapp($number, $message);

        return $this->respond([
            'whatsapp_number' => $number,
            'otp_code' => $otpCode, // note: jangan tampilkan ini di production
        ]);
    }

    public function verifyOtp()
    {
        $number = $this->request->getPost('whatsapp_number');
        $code = $this->request->getPost('otp_code');

        if (!$number || !$code) {
            return $this->failValidationErrors([
                'whatsapp_number' => 'Nomor WhatsApp wajib diisi.',
                'otp_code' => 'Kode OTP wajib diisi.',
            ]);
        }

        $otpModel = new OtpWhatsappModel();
        $row = $otpModel
            ->where('whatsapp_number', $this->heroic->normalizePhoneNumber($number))
            ->where('otp_code', $code)
            ->where('expired_at >=', date('Y-m-d H:i:s'))
            ->orderBy('id', 'DESC')
            ->first();

        if (!$row) {
            return $this->respond(['isValid' => false, 'isExist' => false]);
        }

        $userModel = new UserModel();
        $user = $userModel->where('phone', $number)->where('deleted_at', null)->first();

        // Update last active
        if ($user) {
            $userModel->update($user['id'], [
                'last_active' => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->respond([
            'isValid' => true,
            'isExist' => $user ? true : false,
            'token' => JWT::encode(['whatsapp_number' => $number], config('Heroic')->jwtKey['secret'], 'HS256'),
        ]);
    }

    public function sendOtpEmail()
    {
        $identity = $this->request->getPost('identity');
        if (!$identity) {
            return $this->failValidationErrors(['identity' => 'Email harus diisi.']);
        }

        $model = new OtpRequests();

        // Rate limit (60 detik)
        $lastOtp = $model->where('identity', $identity)->orderBy('id', 'DESC')->first();
        if ($lastOtp && strtotime($lastOtp['created_at']) > time() - 60) {
            return $this->fail('OTP sudah dikirim. Silakan tunggu 60 detik.');
        }

        $otpCode = random_int(100000, 999999);
        $expiredAt = date('Y-m-d H:i:s', time() + 300);

        $model->insert([
            'otp_code' => $otpCode,
            'identity' => $identity,
            'type' => 'email',
            'expired_at' => $expiredAt,
            'reminded' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Kirim via Email
        $subject = "Kode Verifikasi RuangAI";
        $message = "Terima kasih telah menggunakan aplikasi RuangAI.<br><br>Untuk melanjutkan proses login atau pendaftaran, silakan masukkan kode verifikasi berikut ini ke dalam aplikasi:<br><br><b>$otpCode</b><br><br>Salam,";
        $this->heroic->sendEmail($identity, $subject, $message);

        return $this->respond([
            'identity' => $identity,
            'otp_code' => $otpCode, // note: jangan tampilkan ini di production
        ]);
    }

    public function verifyOtpEmail()
    {
        $identity = $this->request->getPost('identity');
        $code = $this->request->getPost('otp_code');

        if (!$identity || !$code) {
            return $this->failValidationErrors([
                'identity' => 'Email wajib diisi.',
                'otp_code' => 'Kode OTP wajib diisi.',
            ]);
        }

        $otpModel = new OtpRequests();
        $row = $otpModel
            ->where('identity', $identity)
            ->where('otp_code', $code)
            ->where('expired_at >=', date('Y-m-d H:i:s'))
            ->orderBy('id', 'DESC')
            ->first();

        if (!$row) {
            return $this->respond(['isValid' => false, 'isExist' => false]);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $identity)->where('deleted_at', null)->first();

        // Update last active
        if ($user) {
            $userModel->update($user['id'], [
                'last_active' => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->respond([
            'isValid' => true,
            'isExist' => $user ? true : false,
            'token' => JWT::encode(['email' => $identity], config('Heroic')->jwtKey['secret'], 'HS256'),
        ]);
    }
}
