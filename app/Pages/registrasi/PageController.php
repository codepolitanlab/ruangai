<?php namespace App\Pages\registrasi;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController
{
    use ResponseTrait;

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
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();

        // Check if phone not exist
        $found = $db->query('SELECT phone FROM users where phone = :phone:', ['phone' => $phone])->getRow();
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
            'pwd' => $password,
            'token' => $token,
            'otp' => $otp,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $db->table('users')->insert($userData);
        $id = $db->insertID();
        if($db->affectedRows() > 0)
        {
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
                'id' => $id,
                'token' => $token
            ]);
            
        } else {
            return $this->respond([
                'success' => 0, 'message' => 'Gagal menambahkan akun. Silahkan coba kembali.'
            ]);
        }
    }

}