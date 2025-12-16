<?php

namespace App\Pages\registrasi;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Masuk',
    ];

    // Submit new user
    public function postIndex()
    {
        $request    = service('request');
        $validation = service('validation');

        $validation->setRules([
            'fullname'        => 'required|min_length[2]',
            'email'           => 'required|valid_email',
            'password'        => 'required|max_length[50]|min_length[6]',
            'repeat_password' => 'required|matches[password]',
        ], [
            'fullname' => [
                'required'   => 'Nama lengkap wajib diisi',
                'min_length' => 'Nama lengkap minimal 2 karakter',
            ],
            'email' => [
                'required'    => 'Email wajib diisi',
                'valid_email' => 'Format email tidak valid',
            ],
            'password' => [
                'required'   => 'Kata sandi wajib diisi',
                'max_length' => 'Kata sandi maksimal 50 karakter',
                'min_length' => 'Kata sandi minimal 6 karakter',
            ],
            'repeat_password' => [
                'required' => 'Ulangi kata sandi wajib diisi',
                'matches'  => 'Ulangi kata sandi tidak sesuai dengan kata sandi',
            ],
        ]);

        if (! $validation->run($request->getPost())) {
            $errors = $validation->getErrors();

            return $this->respond([
                'success' => 0, 'errors' => $errors,
            ]);
        }
        $validData = $validation->getValidated();

        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db     = \Config\Database::connect();

        // Check google recaptcha response
        $recaptchaResponse  = $request->getPost('recaptcha');
        $recaptchaSecretKey = config('Heroic')->recaptcha['secretKey'];
        $Recaptcha          = new \ReCaptcha\ReCaptcha($recaptchaSecretKey);
        $resp               = $Recaptcha->setExpectedHostname($_SERVER['HTTP_HOST'])->verify($recaptchaResponse, $_SERVER['REMOTE_ADDR']);
        if (! $resp->isSuccess()) {
            return $this->respond(['success' => 0, 'message' => 'Terjadi kesalahan saat mengecek recaptcha: ' . implode(', ', $resp->getErrorCodes())]);
        }

        // Check if email not exist
        $found = $db->query('SELECT email FROM users where email = :email:', ['email' => $validData['email']])->getRow();
        if ($found) {
            return $this->respond([
                'success' => 0,
                'errors'  => ['email' => 'Email sudah terdaftar. Mungkin Anda bisa mencoba fitur Lupa Kata Sandi.'],
            ]);
        }

        // Register user to database
        $Phpass   = new \App\Libraries\Phpass();
        $password = $Phpass->HashPassword($validData['password']);

        // Get only alphanumeric for username
        $username = preg_replace('/[^a-z0-9]/', '', strtolower($validData['fullname']));
        $username .= rand(100, 999);

        $userData = [
            'name'       => $validData['fullname'],
            'username'   => $username,
            'email'      => $validData['email'],
            'pwd'        => $password,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $db->table('users')->insert($userData);
        $id = $db->insertID();
        if ($id) {
            // Check login to database directly using $db
            $Auth                      = new \App\Libraries\Auth();
            [$status, $message, $user] = $Auth->login($validData['email'], $validData['password']);

            return $this->respond([
                'success' => 1,
                'jwt'     => $user['jwt'] ?? '',
            ]);
        }

        return $this->respond([
            'success' => 0, 'message' => 'Gagal menambahkan akun. Silahkan coba kembali.',
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
            $EmailSender->setTemplate('registration', $body);
            return $EmailSender->send($user['email'], 'Konfirmasi Registrasi Akun');
        }

        return [
            'status' => false,
            'message' => 'Alamat email tidak valid.'
        ];
    }
}
