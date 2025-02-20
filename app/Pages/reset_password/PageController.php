<?php namespace App\Pages\reset_password;

use App\Pages\MobileBaseController;
use CodeIgniter\API\ResponseTrait;

class PageController extends MobileBaseController 
{
    use ResponseTrait;
    
    public function getContent()
    {
        $this->data['recaptcha_site_key'] = config('App')->recaptcha['siteKey'];

        return pageView('reset_password/index', $this->data);
    }
    
    public function postIndex()
    {
        $sendto = $this->request->getPost('sendto');
        $email = $this->request->getPost('email', FILTER_VALIDATE_EMAIL);
        $phone = $this->request->getPost('phone');
        $recaptchaResponse = $this->request->getPost('recaptcha');

        if($sendto == 'email' && !$email) {
            return $this->respond(['success' => 0, 'message' => 'Email tidak valid.']);
        }

        if($sendto != 'email' && !$phone) {
            return $this->respond(['success' => 0, 'message' => 'Nomor Whatsapp tidak valid.']);
        }

        // Get database pesantren
        $db = \Config\Database::connect();

        // Check google recaptcha response
        $recaptchaSecretKey = config('App')->recaptcha['secretKey'];
        $Recaptcha = new \ReCaptcha\ReCaptcha($recaptchaSecretKey);
        $resp = $Recaptcha->setExpectedHostname($_SERVER['HTTP_HOST'])
                        ->verify($recaptchaResponse, $_SERVER['REMOTE_ADDR']);
        if (! $resp->isSuccess()) {
            return $this->respond(['success' => 0, 'message' => 'Terjadi kesalahan saat mengecek recaptcha: '. implode(', ', $resp->getErrorCodes())]);
        }

        // Make sure the number begin with 62
        if($sendto == 'phone') 
        {
            $phone = substr($phone, 0, 1)=='0' 
                ? substr_replace($phone, '62', 0, 1) 
                : $phone;
            if(substr($phone, 0, 1)=='8') 
                $phone = '62'.$phone;
            
            // Get user
            $query = "SELECT id, name, phone FROM users WHERE phone = :phone:";
            $user = $db->query($query, ['phone' => $phone])->getRowArray();
        } else {
            // Get user
            $query = "SELECT id, name, email FROM users WHERE email = :email:";
            $user = $db->query($query, ['email' => $email])->getRowArray();
        }

        if($user) 
        {
            // Update token and otp
            helper('text');
            $otp = random_string('numeric', 6);
            $token = sha1($otp);
            $db->table('users')->where('id', $user['id'])->update([
                'token' => $token,
                'otp' => $otp
            ]);

            // Send otp to whatsapp
            $response = $this->sendOTP($user, $otp);

            return $this->respond([
                'success' => 1, 'token' => $token, 'id' => $user['id']
            ]);
        } else {
            
            return $this->respond([
                'success' => 0, 'message' => 'Akun tidak ditemukan.'
            ]);
        }
    }

    public function sendOTP($user, $otp) 
    {
        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();

        // Send OTP
        $appSetting = $db->table('mein_options')
                ->where('option_name', 'app_title')
                ->where('option_group', 'masagi')
                ->get()->getRowArray();
        $namaAplikasi = $appSetting['option_value'] ?? null; 

        if(isset($user['email']))
        {
            $message = "Halo {$user['name']},<br><br>";
            $message .= "Kami menerima permintaan penggantian kata sandi untuk akun Anda di aplikasi <b>{$namaAplikasi}</b><br>";
            $message .= "Untuk melanjutkan, silahkan masukan kode reset kata sandi berikut ini ke dalam aplikasi:<br><br>";
            $message .= "<b>{$otp}</b><br><br>";
            $message .= "Salam,";
            return $Heroic->sendEmail($user['email'], 'Kode Reset Kata Sandi', $message);
        } else {
            $message = <<<EOD
            Halo {$user['name']},

            Kami menerima permintaan penggantian kata sandi untuk akun Anda di aplikasi *{$namaAplikasi}*.
            Untuk melanjutkan, silahkan masukan kode reset kata sandi berikut ini ke dalam aplikasi:

            *{$otp}*

            Salam,
            EOD;
            return $Heroic->sendWhatsapp($user['phone'], $message);
        }
    }
}