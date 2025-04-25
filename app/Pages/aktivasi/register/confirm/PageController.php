<?php namespace App\Pages\aktivasi\register\confirm;

use App\Pages\BaseController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class PageController extends BaseController 
{

    public function getSupply($token)
    {
        $decoded = JWT::decode($token, new Key(config('App')->jwtKey['secret'], 'HS256'));
        if($decoded) {
            $db = \Config\Database::connect();
            $anggota = $db->table('mein_users')
                            ->where('id', $decoded->id)
                            ->where('token', $decoded->token)
                            ->where('status', 'inactive')
                            ->get()->getRowArray();

            if($anggota)
                return $this->respond(['found' => 1, 'id' => $decoded->id, 'token' => $decoded->token]);
            else
                return $this->respond(['found' => 0, 'message' => 'Invalid token']);
        }

        return $this->respond(['found' => 0, 'message' => 'Invalid empty token']);
    }
    
    // Submit OTP Confirmation
    public function postIndex()
    {
        $request = service('request');

        $otp = $request->getPost('otp');
        $token = $request->getPost('token');
        $id = $request->getPost('id');

        $db = \Config\Database::connect();

        // Get user
        $query = "SELECT otp, token, username FROM mein_users WHERE id = :id:";
        $user = $db->query($query, ['id' => $id])->getRow();
        if($user?->otp != $otp || $user?->token != $token) {
            return $this->respond([
                'success' => 0, 'message' => 'Kode OTP yang anda masukkan salah.'
            ]);
        } else {
            // Activate user status
            $query = "UPDATE mein_users SET status = 'active', token = NULL, otp = NULL WHERE id = :id:";
            $db->query($query, ['id' => $id]);

            // Update status aktivasi
            $db->table('anggota')->where('npa', $user->username)->set('status', 1)->update();

            // Create JWT session
            $userSession = [
                'logged_in' => true,
                'user_id' => $id,
                'username' => $user->username,
                'timestamp' => time()
            ];
            $jwt = JWT::encode($userSession, config('App')->jwtKey['secret'], 'HS256');

            return $this->respond([
                'success' => 1, 'jwt' => $jwt
            ]);
        }
    }

    // Submit request to resend OTP 
    public function postResend() 
    {
        $id = $this->request->getPost('id');
        $token = $this->request->getPost('token');

        // Get database pesantren
        $db = \Config\Database::connect();
        $query = "SELECT name, phone, token FROM mein_users WHERE id = :id:";
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
        $query = "UPDATE mein_users SET otp = :otp:, token = :token: WHERE id = :id:";
        $db->query($query, ['otp' => $otp, 'token' => $token, 'id' => $id]);

        // Send OTP
        $appSetting = $db->table('mein_options')
                          ->where('option_name', 'app_title')
                          ->where('option_group', 'masagi')
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

        $jwt = JWT::encode(['id' => $id, 'token' => $token], config('App')->jwtKey['secret'], 'HS256');
        return $this->respond([
            'success' => 1, 'message' => 'Kode OTP berhasil dikirim ulang.', 'token' => $jwt
        ]);
    }
}