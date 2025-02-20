<?php namespace App\Pages\registrasi;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController
{    
    public function getContent()
    {
        return pageView('registrasi/index', $this->data);
    }

    // Submit new user
    public function postIndex()
    {
        $request = service('request');
        $validation = service('validation');

        $validation->setRules([
            'fullname' => 'required|min_length[2]',
            'whatsapp' => 'required',
            'password' => 'required|max_length[50]|min_length[6]',
            'repeat_password' => 'required|matches[password]',
        ]);

        if (! $validation->run($request->getPost())) {
            $errors = $validation->getErrors();
            return $this->respond([
                'success' => 0, 'errors' => $errors
            ]);
        }
        $validData = $validation->getValidated();

        // Make sure the number begin with 62
		$phone = substr($validData['whatsapp'], 0, 1)=='0' 
		? substr_replace($validData['whatsapp'], '62', 0, 1) 
		: $validData['whatsapp'];
		if(substr($phone, 0, 1)=='8') 
			$phone = '62'.$phone;

        // Get database pesantren
        $Tarbiyya = new \App\Libraries\Tarbiyya();
        $db = $Tarbiyya->initDBPesantren();

        // Check if phone not exist
        $found = $db->query('SELECT phone FROM mein_users where phone = :phone:', ['phone' => $phone])->getRow();
        if($found) {
            return $this->respond([
                'success' => 0,
                'errors' => ['whatsapp' => 'Nomor WhatsApp sudah terdaftar']
            ]);
        } 

        // Register user to database
        $Phpass = new \App\Libraries\Phpass();
        $password = $Phpass->HashPassword($validData['password']);
        
        helper('text');
        $otp = random_string('numeric', 6);
        $token = sha1($otp);

        $userData = [
            'name' => $validData['fullname'],
            'phone' => $phone,
            'username' => $phone,
            'password' => $password,
            'token' => $token,
            'otp' => $otp,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $db->table('mein_users')->insert($userData);
        $id = $db->insertID();
        if($db->affectedRows() > 0)
        {
            // Send OTP
            $appSetting = $db->table('mein_options')
                          ->where('option_name', 'app_title')
                          ->where('option_group', 'tarbiyya')
                          ->get()->getRowArray();
            $namaAplikasi = $appSetting['option_value'] ?? null; 

            $message = "Halo {$userData['name']},\n            
Terima kasih telah mendaftar di aplikasi {$namaAplikasi}
Untuk melanjutkan proses pendaftaran, silahkan masukan kode registrasi berikut ini ke dalam aplikasi:\n
*{$userData['otp']}*\n
Salam,";
            $this->_sendOTP($phone, $message);

            return $this->respond([
                'success' => 1,
                'id' => $id,
                'token' => $token
            ]);
            
        } else {
            return $this->respond([
                'success' => 0, 'message' => 'Gagal menambahkan akun. Silahkan coba kembali.'
            ]);
        }
    }

    private function _sendOTP($number, $message) 
    {
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
            'to' => $number,
            'message' => $message,
            'sandbox' => 'false'
            ),
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

}