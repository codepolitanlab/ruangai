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

        helper('text');
        $otp   = random_string('numeric', 6);
        $token = sha1($otp);

        $userData = [
            'name'       => $validData['fullname'],
            'phone'      => $phone,
            'username'   => $phone,
            'pwd'        => $password,
            'token'      => $token,
            'otp'        => $otp,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $db->table('users')->insert($userData);
        $id = $db->insertID();
        if ($db->affectedRows() > 0) {
            // Send OTP
            $message = <<<EOD
                Halo {$userData['name']},\n
                Terima kasih telah mendaftar di aplikasi RuangAI
                Untuk melanjutkan proses pendaftaran, silahkan masukan kode registrasi berikut ini ke dalam aplikasi:\n
                *{$userData['otp']}*\n
                Salam
                EOD;
            $Heroic->sendWhatsapp($phone, $message);

            return $this->respond([
                'success' => 1,
                'id'      => $id,
                'token'   => $token,
            ]);
        }

        return $this->respond([
            'success' => 0, 'message' => 'Gagal menambahkan akun. Silahkan coba kembali.',
        ]);
    }
}
