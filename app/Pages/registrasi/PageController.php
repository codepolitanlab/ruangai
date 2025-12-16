<?php

namespace App\Pages\registrasi;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Daftar Akun',
    ];

    // Submit new user registration
    public function postIndex()
    {
        $request    = service('request');
        $validation = service('validation');

        $validation->setRules([
            'fullname'        => 'required|min_length[2]',
            'phone'           => 'required',
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
                'success' => 0, 
                'errors' => $errors,
            ]);
        }
        $validData = $validation->getValidated();

        // Make sure the phone number begins with 62
        $phone = substr($validData['phone'], 0, 1) === '0'
            ? substr_replace($validData['phone'], '62', 0, 1)
            : $validData['phone'];
        if (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }

        // Get database connection
        $db = \Config\Database::connect();

        // Check if phone already exists
        $foundPhone = $db->query('SELECT phone FROM users WHERE phone = :phone:', ['phone' => $phone])->getRow();
        if ($foundPhone) {
            return $this->respond([
                'success' => 0,
                'errors'  => ['phone' => 'Nomor telepon sudah terdaftar'],
            ]);
        }

        // Check if email already exists
        $foundEmail = $db->query('SELECT email FROM users WHERE email = :email:', ['email' => $validData['email']])->getRow();
        if ($foundEmail) {
            return $this->respond([
                'success' => 0,
                'errors'  => ['email' => 'Email sudah terdaftar'],
            ]);
        }

        // Hash password
        $Phpass   = new \App\Libraries\Phpass();
        $password = $Phpass->HashPassword($validData['password']);

        // Generate username from email (before @ symbol) or phone
        $username = explode('@', $validData['email'])[0];
        // Check if username exists, if yes add random number
        $usernameCheck = $db->query('SELECT username FROM users WHERE username = :username:', ['username' => $username])->getRow();
        if ($usernameCheck) {
            $username = $username . rand(100, 999);
        }

        $userData = [
            'name'       => $validData['fullname'],
            'phone'      => $phone,
            'email'      => $validData['email'],
            'username'   => $username,
            'pwd'        => $password,
            'status'     => null,
            'active'     => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        
        $db->table('users')->insert($userData);
        $id = $db->insertID();
        
        if ($db->affectedRows() > 0) {
            return $this->respond([
                'success' => 1,
                'id'      => $id,
                'message' => 'Registrasi berhasil! Silakan login untuk melanjutkan.',
            ]);
        }

        return $this->respond([
            'success' => 0, 
            'message' => 'Gagal menambahkan akun. Silahkan coba kembali.',
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
