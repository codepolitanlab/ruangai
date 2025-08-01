<?php

namespace App\Controllers\Api;

use App\Libraries\Heroic;
use App\Models\OtpRequests;
use App\Models\OtpWhatsappModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;
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

    public function login()
    {
        $data = $this->request->getPost();

        // Validate data
        if (! isset($data['email'], $data['password'])) {
            return $this->failValidationErrors(['message' => 'Mohon untuk melengkapi data.']);
        }

        $Auth                      = new \App\Libraries\Auth();
        [$status, $message, $user] = $Auth->login($data['email'], $data['password']);

        if ($status === 'failed') {
            return $this->fail($message);
        }

        return $this->respond([
            'status' => $status,
            'token'  => $user['jwt'],
        ]);
    }

    public function register()
    {
        $data = $this->request->getPost();

        // Validate
        if (! isset($data['email'], $data['password'], $data['whatsapp_number'])) {
            return $this->failValidationErrors(['message' => 'Mohon untuk melengkapi data.']);
        }

        $userModel = new UserModel();
        $user      = $userModel->where('LOWER(email)', $data['email'])->orWhere('phone', $data['whatsapp_number'])->where('deleted_at', null)->first();
        if ($user) {
            return $this->fail('Akun sudah terdaftar.');
        }

        // Register user to database
        $Phpass   = new \App\Libraries\Phpass();
        $password = $Phpass->HashPassword(trim($data['password']));

        $username = explode('@', $data['email']);
        $userModel->insert([
            'email'    => strtolower($data['email']),
            'username' => strtolower(substr($username[0], 0, 5)) . '_' . mt_rand(1000, 9999),
            'pwd'      => $password,
            'phone'    => $this->heroic->normalizePhoneNumber($data['whatsapp_number']),
        ]);

        $body = [
            'name' => 'Warrior',
        ];

        $EmailSender = new \App\Libraries\EmailSender();
        $EmailSender->setTemplate('registration', $body);
        $EmailSender->send($data['email'], 'Pendaftaran Akun Berhasil');

        return $this->respond(['status' => 'success', 'message' => 'Pengguna berhasil didaftarkan.']);
    }

    public function forgotPassword()
    {
        $data = $this->request->getPost();

        // Validate
        if (empty($data['email']) || empty($data['callback']) || empty($data['token'])) {
            return $this->failValidationErrors(['message' => 'Mohon untuk melengkapi data.']);
        }

        if ($this->_verifyRecaptcha($data['token'])) {
            $userModel = new UserModel();

            $forgotPassword = $userModel->forgotPassword($data['email'], true, false, $data['callback']);

            if ($forgotPassword['status'] === 'success') {
                return $this->respond(['status' => 'success', 'message' => $forgotPassword['message']]);
            }

            return $this->fail(['status' => 'failed', 'message' => $forgotPassword['message']]);
        }

        return $this->fail([
            'status'  => 'failed',
            'message' => 'Failed captcha',
        ]);
    }

    public function resetPassword()
    {
        $data = $this->request->getPost();

        // Validate not isset and not empty
        if (empty($data['password']) || empty($data['token'])) {
            return $this->failValidationErrors(['message' => 'Mohon untuk melengkapi data.']);
        }

        $userModel     = new UserModel();
        $resetPassword = $userModel->resetPassword($data['token'], $data['password']);

        if ($resetPassword['status'] === 'failed') {
            return $this->fail('Akun tidak terdaftar atau OTP expired.');
        }

        return $this->respond(['status' => 'success', 'message' => $resetPassword['message']]);
    }

    private function _verifyRecaptcha($token)
    {
        $secret = '6LegjmApAAAAADEJOdhueo68VXfHALLhhZ4Am9Od'; // Obtain from reCAPTCHA admin console
        $url    = 'https://www.google.com/recaptcha/api/siteverify';
        $data   = [
            'secret'   => $secret,
            'response' => $token,
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        $result  = file_get_contents($url, false, $context);

        if ($result === false) {
            // Error fetching reCAPTCHA verification response
            return false;
        }

        $response = json_decode($result);

        return (bool) ($response->success);
        // reCAPTCHA verification succeeded

        // reCAPTCHA verification failed
    }

    public function sendOtp()
    {
        $number = $this->request->getPost('whatsapp_number');
        if (! $number) {
            return $this->failValidationErrors(['whatsapp_number' => 'Nomor WhatsApp harus diisi.']);
        }

        $model = new OtpWhatsappModel();

        // Rate limit (60 detik)
        $lastOtp = $model->where('whatsapp_number', $number)->orderBy('id', 'DESC')->first();
        if ($lastOtp && strtotime($lastOtp['created_at']) > time() - 60) {
            return $this->fail('OTP sudah dikirim. Silakan tunggu 60 detik.');
        }

        $otpCode   = random_int(100000, 999999);
        $expiredAt = date('Y-m-d H:i:s', time() + 60);

        $model->insert([
            'otp_code'        => $otpCode,
            'whatsapp_number' => $number,
            'expired_at'      => $expiredAt,
            'created_at'      => date('Y-m-d H:i:s'),
        ]);

        // Kirim via WhatsApp
        $message = "Terima kasih telah menggunakan aplikasi RuangAI.\n\nUntuk melanjutkan proses login atau pendaftaran, silakan masukkan kode verifikasi berikut ini ke dalam aplikasi:\n\n*{$otpCode}*\n\nSalam,";
        $this->heroic->sendWhatsapp($number, $message);

        return $this->respond([
            'whatsapp_number' => $number,
            'otp_code'        => $otpCode, // note: jangan tampilkan ini di production
        ]);
    }

    public function verifyOtp()
    {
        $number = $this->request->getPost('whatsapp_number');
        $code   = $this->request->getPost('otp_code');

        if (! $number || ! $code) {
            return $this->failValidationErrors([
                'whatsapp_number' => 'Nomor WhatsApp wajib diisi.',
                'otp_code'        => 'Kode OTP wajib diisi.',
            ]);
        }

        $number = $this->heroic->normalizePhoneNumber($number);

        $otpModel = new OtpWhatsappModel();
        $row      = $otpModel
            ->where('whatsapp_number', $number)
            ->where('otp_code', $code)
            ->where('expired_at >=', date('Y-m-d H:i:s'))
            ->orderBy('id', 'DESC')
            ->first();

        if (! $row) {
            return $this->respond(['isValid' => false, 'isExist' => false]);
        }

        $userModel = new UserModel();
        $user      = $userModel->where('phone', $number)->where('deleted_at', null)->first();

        // Update last active
        if ($user) {
            $userModel->update($user['id'], [
                'last_active' => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->respond([
            'isValid' => true,
            'isExist' => $user ? true : false,
            'token'   => JWT::encode(['whatsapp_number' => $number], config('Heroic')->jwtKey['secret'], 'HS256'),
        ]);
    }

    public function sendOtpEmail()
    {
        $identity = $this->request->getPost('identity');
        if (! $identity) {
            return $this->failValidationErrors(['identity' => 'Email harus diisi.']);
        }

        $model = new OtpRequests();

        // Rate limit (60 detik)
        $lastOtp = $model->where('identity', $identity)->orderBy('id', 'DESC')->first();
        if ($lastOtp && strtotime($lastOtp['created_at']) > time() - 60) {
            return $this->fail('OTP sudah dikirim. Silakan tunggu 60 detik.');
        }

        $otpCode   = random_int(100000, 999999);
        $expiredAt = date('Y-m-d H:i:s', time() + 300);

        $model->insert([
            'otp_code'   => $otpCode,
            'identity'   => $identity,
            'type'       => 'email',
            'expired_at' => $expiredAt,
            'reminded'   => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Kirim via Email
        $subject = 'Kode Verifikasi RuangAI';
        $message = "Terima kasih telah menggunakan aplikasi RuangAI.<br><br>Untuk melanjutkan proses verifikasi Email, silakan masukkan kode verifikasi berikut ini ke dalam aplikasi:<br><br><b>{$otpCode}</b><br><br>Salam,";
        $this->heroic->sendEmail($identity, $subject, $message);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Kode verifikasi telah dikirim ke email Anda.', // note: jangan tampilkan ini di production
        ]);
    }

    public function verifyOtpEmail()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        $identity = $this->request->getPost('identity');
        $code     = $this->request->getPost('otp_code');

        if (! $identity || ! $code) {
            return $this->failValidationErrors([
                'identity' => 'Email wajib diisi.',
                'otp_code' => 'Kode OTP wajib diisi.',
            ]);
        }

        $userModel = new UserModel();
        // Check table users email_valid
        $user = $userModel->where('LOWER(email)', $identity)->where('deleted_at', null)->first();

        if (! $user) {
            return $this->fail(['status' => 'failed', 'message' => 'Email tidak terdaftar.']);
        }

        if ($user['email_valid'] === 1) {
            return $this->fail(['status' => 'failed', 'message' => 'Email sudah terverifikasi.']);
        }

        $otpModel = new OtpRequests();
        $row      = $otpModel
            ->where('identity', $identity)
            ->where('otp_code', $code)
            ->where('expired_at >=', date('Y-m-d H:i:s'))
            ->orderBy('id', 'DESC')
            ->first();

        if (! $row) {
            return $this->fail(['status' => 'failed', 'message' => 'Kode OTP salah atau kadaluarsa.']);
        }

        // Set email_valid to table users where user_id and identity email
        $userModel->update($user['id'], ['email_valid' => 1]);

        // Send token to user
        $token = JWT::encode([
            'email'           => strtolower($user['email']),
            'whatsapp_number' => $user['phone'],
            'user_id'         => $user['id'],
            'isValidEmail'    => $user['email_valid'],
            'exp'             => time() + 7 * 24 * 60 * 60,
        ], config('Heroic')->jwtKey['secret'], 'HS256');

        return $this->respond([
            'status'  => 'success',
            'message' => 'Verifikasi email berhasil.',
            'token'   => $token,
        ]);
    }
}
