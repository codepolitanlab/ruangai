<?php namespace App\Pages\reset_password\change;

use App\Pages\MobileBaseController;
use Firebase\JWT\JWT;

class PageController extends MobileBaseController 
{
    public function getContent()
    {
        return pageView('reset_password/change/index', $this->data);
    }
    
    public function postIndex()
    {
        $request = service('request');

        $token = $request->getPost('token');
        $otp = trim($request->getPost('otp'));
        $id = $request->getPost('id');
        $password = trim($request->getPost('password'));

        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();

        // Get user
        $query = "SELECT otp, token, email FROM users WHERE id = :id:";
        $user = $db->query($query, ['id' => $id])->getRow();
        if($user?->otp != $otp || $user?->token != $token) {
            return $this->respond([
                'success' => 0, 'message' => 'Kode Reset yang anda masukkan salah.'
            ]);
        } else {
            // Update password
            $Phpass = new \App\Libraries\Phpass();
            $password = $Phpass->HashPassword($password);
            $query = "UPDATE users SET status = 'active', token = NULL, otp = NULL, password = :password: WHERE id = :id:";
            $db->query($query, ['id' => $id, 'password' => $password]);

            // Create JWT
            $userSession = [
                'logged_in' => true,
                'user_id' => $id,
                'email' => $user->email,
                'timestamp' => time()
            ];
            $key = config('Heroic')->jwtKey['secret'];
            $jwt = JWT::encode($userSession, $key, 'HS256');

            return $this->respond([
                'success' => 1, 'jwt' => $jwt
            ]);
        }
    }

    public function postResend() 
    {
        $id = $this->request->getPost('id');
        $token = $this->request->getPost('token');

        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();
        $query = "SELECT name, phone, token FROM users WHERE id = :id:";
        $user = $db->query($query, ['id' => $id])->getRow();
        if(strcmp($user?->token, $token) !== 0) {
            header('Content-Type', 'application/json');
            return $this->respond([
                'success' => 0, 'message' => 'Token invalid.'
            ]);
        }
        
        // Generate new OTP and token
        helper('text');
        $otp = random_string('numeric', 6);
        $token = sha1($otp);

        // Update new otp and token to database
        $query = "UPDATE users SET otp = :otp:, token = :token: WHERE id = :id:";
        $db->query($query, ['otp' => $otp, 'token' => $token, 'id' => $id]);

        // Send OTP
        $appSetting = $db->table('mein_options')
                          ->where('option_name', 'app_title')
                          ->where('option_group', 'tarbiyya')
                          ->get()->getRowArray();
        $namaAplikasi = $appSetting['option_value'] ?? null; 

        $message = "Halo {$user->name},\n            
Terima kasih telah mendaftar di aplikasi {$namaAplikasi}
Untuk melanjutkan proses pendaftaran, silahkan masukan kode registrasi berikut ini ke dalam aplikasi:\n
*{$otp}*\n
Salam,";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://app.saungwa.com/api/create-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
            'appkey' => '1e946b6b-e8ab-4c6a-ac7b-b2ae4204f095',
            'authkey' => 'Bl25APBU3Tcahyo9Rd0ZcCbloR4Gj1i6Ll5lRq6Y3J4DikKUS4',
            'to' => $user->phone,
            'message' => $message,
            'sandbox' => 'false'
            ),
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $this->respond([
            'success' => 1, 'message' => 'Kode OTP berhasil dikirim ulang.', 'token' => $token, 'id' => $id
        ]);
    }
}