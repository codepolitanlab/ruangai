<?php

namespace App\Pages\reset_password;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public function postIndex()
    {
        $sendto            = $this->request->getPost('sendto');
        $email             = $this->request->getPost('email', FILTER_VALIDATE_EMAIL);
        $phone             = $this->request->getPost('phone');
        $recaptchaResponse = $this->request->getPost('recaptcha');

        if ($sendto === 'email' && ! $email) {
            return $this->respond(['success' => 0, 'message' => 'Email tidak valid.']);
        }

        if ($sendto !== 'email' && ! $phone) {
            return $this->respond(['success' => 0, 'message' => 'Nomor Whatsapp tidak valid.']);
        }

        // Get database pesantren
        $db = \Config\Database::connect();

        // Check google recaptcha response
        $recaptchaSecretKey = config('Heroic')->recaptcha['secretKey'];
        $Recaptcha          = new \ReCaptcha\ReCaptcha($recaptchaSecretKey);
        $resp               = $Recaptcha->setExpectedHostname($_SERVER['HTTP_HOST'])
            ->verify($recaptchaResponse, $_SERVER['REMOTE_ADDR']);
        if (! $resp->isSuccess()) {
            return $this->respond(['success' => 0, 'message' => 'Terjadi kesalahan saat mengecek recaptcha: ' . implode(', ', $resp->getErrorCodes())]);
        }

        // Make sure the number begin with 62
        if ($sendto === 'phone') {
            $phone = substr($phone, 0, 1) === '0'
                ? substr_replace($phone, '62', 0, 1)
                : $phone;
            if (substr($phone, 0, 1) === '8') {
                $phone = '62' . $phone;
            }

            // Get user
            $query = 'SELECT id, name, phone FROM users WHERE phone = :phone:';
            $user  = $db->query($query, ['phone' => $phone])->getRowArray();
        } else {
            // Get user
            $query = 'SELECT id, name, email FROM users WHERE email = :email:';
            $user  = $db->query($query, ['email' => $email])->getRowArray();
        }

        if ($user) {
            // Update token and otp
            helper('text');
            $otp   = random_string('numeric', 6);
            $token = substr(sha1($otp), -6);
            $db->table('users')->where('id', $user['id'])->update([
                'token' => $token,
                'otp'   => $otp,
            ]);

            // Send otp to whatsapp
            $response = $this->sendOTP($user, $otp);

            return $this->respond([
                'success' => $response['success'], 'token' => $token, 'id' => $user['id'],
            ]);
        }

        return $this->respond([
            'success' => 0, 'message' => 'Akun tidak ditemukan.',
        ]);
    }

    private function sendOTP($user, $otp)
    {
        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db     = \Config\Database::connect();

        // Send OTP
        $namaAplikasi = setting()->get('Heroicadmin.title');

        if (isset($user['email'])) {
            $EmailSender = new \App\Libraries\EmailSender();
            $body        = [
                'name'     => $user['name'],
                'aplikasi' => $namaAplikasi,
                'otp'      => $otp,
            ];
            $EmailSender->setTemplate('reset_password_otp', $body);
            return $EmailSender->send($user['email'], 'Permintaan Reset Password');
        }

        return [
            'status' => false,
            'message' => 'Alamat email tidak valid.'
        ];
    }

    public function getTest()
    {
        $EmailSender = new \App\Libraries\EmailSender();
            $body        = [
                'name'     => 'xxx',
                'aplikasi' => 'yyy',
                'otp'      => 'zzz',
            ];
            $EmailSender->setTemplate('reset_password_otp', $body);
            return $EmailSender->send('test@gmail.com', 'Permintaan Reset Password', null, true);
    }
}
