<?php

namespace App\Pages\aktivasi\register;

use App\Pages\BaseController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class PageController extends BaseController
{
    public function getSupply($token)
    {
        $decoded = JWT::decode($token, new Key(config('App')->jwtKey['secret'], 'HS256'));
        if ($decoded) {
            $db      = \Config\Database::connect();
            $anggota = $db->table('anggota')
                ->where('id', $decoded->id)
                ->where('token', $decoded->token)
                ->where('status', '0')
                ->get()->getRowArray();

            return $this->respond(['found' => 1, 'data' => $anggota]);
        }

        return $this->respond(['found' => 0, 'message' => 'Invalid empty token']);
    }

    // Submit new user
    public function postIndex()
    {
        $request    = service('request');
        $validation = service('validation');
        $Tarbiyya   = new \App\libraries\Tarbiyya();

        $validation->setRules([
            'fullname'        => 'required|min_length[2]',
            'whatsapp'        => 'required',
            'password'        => 'required|max_length[50]|min_length[6]',
            'repeat_password' => 'required|matches[password]',
        ]);

        if (! $validation->run($request->getPost())) {
            $errors = $validation->getErrors();

            return $this->respond([
                'success' => 0, 'errors' => $errors,
            ]);
        }
        $validData = $validation->getValidated();
        $npa       = $request->getPost('npa');

        // Make sure the number begin with 62
        $phone = $Tarbiyya->normalizePhoneNumber($validData['whatsapp']);

        $db = \Config\Database::connect();

        // Check if phone not exist
        $found = $db->query('SELECT id, username, phone, status FROM mein_users where phone = :phone:', ['phone' => $phone])->getRow();
        if ($found && $found->status === 'active') {
            return $this->respond([
                'success' => 0,
                'errors'  => ['whatsapp' => 'Nomor WhatsApp sudah terdaftar'],
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
            'username'   => $npa,
            'password'   => $password,
            'token'      => $token,
            'otp'        => $otp,
            'role_id'    => 3,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Update if user already register but not activated yet
        if ($found?->username === $npa) {
            $db->table('mein_users')
                ->where('id', $found->id)
                ->update($userData);
            $id = $found->id;
        } else {
            $db->table('mein_users')->insert($userData);
            $id = $db->insertID();
        }

        if ($db->affectedRows() > 0) {
            // Send OTP
            $appSetting = $db->table('mein_options')
                ->where('option_name', 'app_title')
                ->where('option_group', 'masagi')
                ->get()->getRowArray();
            $namaAplikasi = $appSetting['option_value'] ?? null;

            $message = "Halo {$userData['name']},\n
Terima kasih telah mendaftar di aplikasi {$namaAplikasi}
Untuk melanjutkan proses pendaftaran, silahkan masukan kode registrasi berikut ini ke dalam aplikasi:\n
*{$userData['otp']}*\n
Salam,";

            $Tarbiyya->sendWhatsapp($phone, $message);

            $jwt = JWT::encode(['id' => $id, 'token' => $token], config('App')->jwtKey['secret'], 'HS256');

            return $this->respond([
                'success' => 1,
                'token'   => $jwt,
            ]);
        }

        return $this->respond([
            'success' => 0, 'message' => 'Gagal menambahkan akun. Silahkan coba kembali.',
        ]);
    }

    private function _sendOTP($number, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://app.saungwa.com/api/create-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => [
                'appkey'  => '1e946b6b-e8ab-4c6a-ac7b-b2ae4204f095',
                'authkey' => 'Bl25APBU3Tcahyo9Rd0ZcCbloR4Gj1i6Ll5lRq6Y3J4DikKUS4',
                'to'      => $number,
                'message' => $message,
                'sandbox' => 'false',
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
