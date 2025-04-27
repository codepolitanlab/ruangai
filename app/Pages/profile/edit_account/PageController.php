<?php namespace App\Pages\profile\edit_account;

use App\Pages\BaseController;
use CodeIgniter\API\ResponseTrait;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PageController extends BaseController {

    

    public $data = [
        'page_title' => 'Edit Akun',
        'module'     => 'profile'
    ];

    public function getSupply()
    {
        
    }

    // type: email|phone
    public function postGenerateToken($type = 'email') 
    {
        $Heroic = new \App\Libraries\Heroic();
        $user = $Heroic->checkToken();

        // Generate token
        helper('text');
        $otp = random_string('numeric', 6);
        $token = sha1($otp);

        // Save token to table users
        $db = \Config\Database::connect();
        $db->table('users')
            ->where('id', $user->user_id)
            ->set(['token' => $token, 'otp_'.$type => $otp])
            ->update();

        return $this->respond(['success' => 1, 'token' => $token]);
    }

    public function postSendOTPEmail()
    {
        $Heroic = new \App\Libraries\Heroic;

        $token = $this->request->getPost('token');
        $email = trim($this->request->getPost('email'));
        $user = $Heroic->checkToken();

        $db = \Config\Database::connect();
        $found = $db->table('users')->where('id', $user->user_id)->get()->getRowArray();
        if (!$found) {
            return $this->respond(['success' => 0, 'message' => 'Token invalid'], 401);
        }

        if ($found['email'] == $email) {
            return $this->respond(['success' => 0, 'message' => 'Email baru sama dengan yang sudah didaftarkan']);
        }

        if(strcmp($found['token'], $token) == 0) 
        {
            $appSetting = $db->table('mein_options')
                          ->where('option_name', 'app_title')
                          ->where('option_group', 'masagi')
                          ->get()->getRowArray();
            $namaAplikasi = $appSetting['option_value'] ?? null; 

            $message = "Halo {$found['name']},<br><br>
            Kami menerima permintaan penggantian nomor WhatsApp dari akun Anda di aplikasi {$namaAplikasi}.<br>
            Untuk melanjutkan, silahkan masukan kode verifikasi berikut ini ke dalam aplikasi:<br><br>
            <b>{$found['otp_email']}</b><br><br>
            Salam,";
            $result = $Heroic->sendEmail($email, "Konfirmasi Penggantian Alamat Email", $message);
            if($result['success']) {
                return $this->respond(['success' => 1, 'message' => 'Kode verifikasi berhasil dikirim ke nomor email Anda']);
            } else {
                return $this->respond(['success' => 0, 'message' => 'Terjadi kesalahan saat mengirim kode verifikasi: '.$result['message']]);
            }
        }
    }

    public function postSendOTPPhone()
    {
        $Heroic = new \App\Libraries\Heroic;

        $token = $this->request->getPost('token');
        $phone = $Heroic->normalizePhoneNumber(trim($this->request->getPost('phone')));
        $user = $Heroic->checkToken();

        $db = \Config\Database::connect();
        $found = $db->table('users')->where('id', $user->user_id)->get()->getRowArray();
        if (!$found) {
            return $this->respond(['success' => 0, 'message' => 'Token invalid'], 401);
        }

        if ($found['phone'] == $phone) {
            return $this->respond(['success' => 0, 'message' => 'Nomor baru sama dengan yang sudah didaftarkan']);
        }

        if(strcmp($found['token'], $token) == 0) 
        {
            $appSetting = $db->table('mein_options')
                          ->where('option_name', 'app_title')
                          ->where('option_group', 'masagi')
                          ->get()->getRowArray();
            $namaAplikasi = $appSetting['option_value'] ?? null; 

            $message = <<<EOD
            Halo {$found['name']},\n            
            Kami menerima permintaan penggantian nomor WhatsApp dari akun Anda di aplikasi {$namaAplikasi}.
            Untuk melanjutkan, silahkan masukan kode verifikasi berikut ini ke dalam aplikasi:\n
            *{$found['otp_phone']}*\n
            Salam,
            EOD;
            $result = $Heroic->sendWhatsapp($phone, $message);
            if($result?->message_status == 'Success') {
                return $this->respond(['success' => 1, 'message' => 'Kode verifikasi berhasil dikirim ke nomor WhatsApp Anda']);
            } else {
                return $this->respond(['success' => 0, 'message' => 'Terjadi kesalahan saat mengirim kode verifikasi']);
            }
        }
    }

    public function postChangePhone()
    {
        $Heroic = new \App\Libraries\Heroic();
        $phone = $Heroic->normalizePhoneNumber(trim($this->request->getPost('phone')));
        $otp = $this->request->getPost('otp');
        $user = $Heroic->checkToken();
        
        $db = \Config\Database::connect();
        $userData = $db->table('users')
                       ->where('id', $user->user_id)
                       ->get()->getRowArray();

        // Check if otp is same
        if($userData['otp_phone'] != $otp) {
            return $this->respond(['success' => 0, 'message' => 'OTP tidak cocok']);
        }

        $data = [
            'phone' => $phone,
            'otp_phone' => '',
            'token' => ''
        ];
        $db->table('users')->where('id', $user->user_id)->update($data);
        if($db->affectedRows() > 0) {
            return $this->respond(['success' => 1, 'message' => 'Nomor WhatsApp berhasil diubah', 'phone' => $phone]);
        } else {
            return $this->respond(['success' => 0, 'message' => 'Nomor WhatsApp gagal diubah']);
        }
    }

    public function postChangeEmail()
    {
        $Heroic = new \App\Libraries\Heroic();
        $email = trim($this->request->getPost('email'));
        $otp = $this->request->getPost('otp');
        $user = $Heroic->checkToken();
        
        $db = \Config\Database::connect();
        $userData = $db->table('users')
                       ->where('id', $user->user_id)
                       ->get()->getRowArray();

        // Check if otp is same
        if($userData['otp_email'] != $otp) {
            return $this->respond(['success' => 0, 'message' => 'OTP tidak cocok']);
        }

        $data = [
            'email' => $email,
            'otp_email' => '',
            'token' => ''
        ];
        $db->table('users')->where('id', $user->user_id)->update($data);
        if($db->affectedRows() > 0) {
            return $this->respond(['success' => 1, 'message' => 'Alamat Email berhasil diubah', 'email' => $email]);
        } else {
            return $this->respond(['success' => 0, 'message' => 'Alamat Email gagal diubah']);
        }
    }

}