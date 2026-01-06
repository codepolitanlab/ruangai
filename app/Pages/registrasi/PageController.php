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
            'fullname'        => 'required|min_length[2]|regex_match[/^[\p{L}\s\'\-]+$/u]',
            'phone'           => 'required|numeric',
            'email'           => 'required|valid_email',
            'password'        => 'required|max_length[50]|min_length[6]',
            'repeat_password' => 'required|matches[password]',
        ], [
            'fullname' => [
                'required'   => 'Nama lengkap wajib diisi',
                'min_length' => 'Nama lengkap minimal 2 karakter',
                'regex_match' => 'Nama tidak boleh mengandung angka atau simbol',
            ],
            'phone' => [
                'required' => 'Nomor telepon wajib diisi',
                'numeric'  => 'Nomor telepon harus berupa angka',
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

        // Check google recaptcha response
        $recaptchaResponse = $this->request->getPost('recaptcha');
        $recaptchaSecretKey = config('Heroic')->recaptcha['secretKey'];
        $Recaptcha          = new \ReCaptcha\ReCaptcha($recaptchaSecretKey);
        $resp               = $Recaptcha->setExpectedHostname($_SERVER['HTTP_HOST'])->verify($recaptchaResponse, $_SERVER['REMOTE_ADDR']);
        if (! $resp->isSuccess()) {
            return $this->respond(['success' => 0, 'errors' => ['recaptcha' => 'Terjadi kesalahan saat mengecek recaptcha: ' . implode(', ', $resp->getErrorCodes())]]);
        }

        // Make sure the phone number begins with 62
        $phone = substr($validData['phone'], 0, 1) === '0'
            ? substr_replace($validData['phone'], '62', 0, 1)
            : $validData['phone'];
        if (substr($phone, 0, 1) === '8') {
            $phone = '62' . $phone;
        }

        // Get database connection
        $db = \Config\Database::connect();

        // Check if email already exists
        $foundEmail = $db->table('users')
            ->select('email')
            ->where('email', $validData['email'])
            ->get()
            ->getRow();
        if ($foundEmail) {
            return $this->respond([
                'success' => 0,
                'errors'  => ['email' => 'Email sudah terdaftar'],
            ]);
        }

        // Check if phone already exists
        $foundPhone = $db->table('users')
            ->select('phone')
            ->where('phone', $phone)
            ->get()
            ->getRow();
        if ($foundPhone) {
            return $this->respond([
                'success' => 0,
                'errors'  => ['phone' => 'Nomor telepon sudah terdaftar'],
            ]);
        }

        // Hash password
        $Phpass   = new \App\Libraries\Phpass();
        $password = $Phpass->HashPassword($validData['password']);

        // Generate username from fullname with alphanumeric and lowercase only
        $username = preg_replace('/[^a-z0-9]/', '', strtolower($validData['fullname']));
        $username = $username . rand(100, 999);

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

        // Accept `source` from POST (preferred) or GET and include it if the `users` table has that column
        $source = $request->getPost('source');
        if ($source === null || $source === '') {
            $source = $request->getGet('source');
        }
        if ($source !== null && $source !== '') {
            $source = substr(trim($source), 0, 100); // limit length
            $fields = $db->getFieldData('users');
            $fieldNames = array_map(function($f) { return $f->name; }, $fields);
            if (in_array('source', $fieldNames)) {
                $userData['source'] = $source;
            }
        }
        
        $db->table('users')->insert($userData);
        $id = $db->insertID();
        
        if ($db->affectedRows() > 0) {
            // Get the newly created user data
            $newUser = $db->table('users')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            // Generate JWT token for auto-login
            $Auth                      = new \App\Libraries\Auth();
            [$status, $message, $user] = $Auth->login($newUser['email'], $validData['password']);

            return $this->respond([
                'success' => 1,
                'id'      => $id,
                'jwt'     => $user['jwt'] ?? '',
                'message' => 'Registrasi berhasil!',
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
