<?php namespace App\Pages\profile\edit_account;

use App\Pages\MobileBaseController;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class PageController extends MobileBaseController {

    public function getContent()
    {
        return pageView('profile/edit_account/index', $this->data);
    }

    public function getSupply()
    {
        
    }

    // type: email|phone
    public function postGenerateToken($type = 'email') 
    {
        $Tarbiyya = new \App\Libraries\Tarbiyya();
        $user = $Tarbiyya->checkToken();

        // Generate token
        helper('text');
        $otp = random_string('numeric', 6);
        $token = sha1($otp);

        // Save token to table mein_users
        $db = \Config\Database::connect();
        $db->table('mein_users')
            ->where('id', $user->user_id)
            ->set(['token' => $token, 'otp_'.$type => $otp])
            ->update();

        return $this->respond(['success' => 1, 'token' => $token]);
    }

    public function postSendOTPEmail()
    {
        $Tarbiyya = new \App\Libraries\Tarbiyya;

        $token = $this->request->getPost('token');
        $email = trim($this->request->getPost('email'));
        $user = $Tarbiyya->checkToken();

        $db = \Config\Database::connect();
        $found = $db->table('mein_users')->where('id', $user->user_id)->get()->getRowArray();
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
            $result = $Tarbiyya->sendEmail($email, "Konfirmasi Penggantian Alamat Email", $message);
            if($result['success']) {
                return $this->respond(['success' => 1, 'message' => 'Kode verifikasi berhasil dikirim ke nomor email Anda']);
            } else {
                return $this->respond(['success' => 0, 'message' => 'Terjadi kesalahan saat mengirim kode verifikasi: '.$result['message']]);
            }
        }
    }

    public function postSendOTPPhone()
    {
        $Tarbiyya = new \App\Libraries\Tarbiyya;

        $token = $this->request->getPost('token');
        $phone = $Tarbiyya->normalizePhoneNumber(trim($this->request->getPost('phone')));
        $user = $Tarbiyya->checkToken();

        $db = \Config\Database::connect();
        $found = $db->table('mein_users')->where('id', $user->user_id)->get()->getRowArray();
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
            $result = $Tarbiyya->sendWhatsapp($phone, $message);
            if($result?->message_status == 'Success') {
                return $this->respond(['success' => 1, 'message' => 'Kode verifikasi berhasil dikirim ke nomor WhatsApp Anda']);
            } else {
                return $this->respond(['success' => 0, 'message' => 'Terjadi kesalahan saat mengirim kode verifikasi']);
            }
        }
    }

    public function postChangePhone()
    {
        $Tarbiyya = new \App\Libraries\Tarbiyya();
        $phone = $Tarbiyya->normalizePhoneNumber(trim($this->request->getPost('phone')));
        $otp = $this->request->getPost('otp');
        $user = $Tarbiyya->checkToken();
        
        $db = \Config\Database::connect();
        $userData = $db->table('mein_users')
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
        $db->table('mein_users')->where('id', $user->user_id)->update($data);
        if($db->affectedRows() > 0) {
            return $this->respond(['success' => 1, 'message' => 'Nomor WhatsApp berhasil diubah', 'phone' => $phone]);
        } else {
            return $this->respond(['success' => 0, 'message' => 'Nomor WhatsApp gagal diubah']);
        }
    }

    public function postChangeEmail()
    {
        $Tarbiyya = new \App\Libraries\Tarbiyya();
        $email = trim($this->request->getPost('email'));
        $otp = $this->request->getPost('otp');
        $user = $Tarbiyya->checkToken();
        
        $db = \Config\Database::connect();
        $userData = $db->table('mein_users')
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
        $db->table('mein_users')->where('id', $user->user_id)->update($data);
        if($db->affectedRows() > 0) {
            return $this->respond(['success' => 1, 'message' => 'Alamat Email berhasil diubah', 'email' => $email]);
        } else {
            return $this->respond(['success' => 0, 'message' => 'Alamat Email gagal diubah']);
        }
    }

}