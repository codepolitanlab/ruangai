<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['name', 'username', 'email', 'avatar', 'role_id', 'pwd', 'phone', 'token', 'last_active', 'phone_valid', 'email_valid', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;

    public function forgotPassword($email, $sendEmail, $sendWhatsapp, $callback)
    {
        $userModel = new UserModel();
        $Heroic    = new \App\Libraries\Heroic();

        $user  = $userModel->where('LOWER(email)', strtolower($email))->where('deleted_at', null)->first();
        $token = $this->generateActivationToken();

        if ($user) {
            $userModel->update($user['id'], ['token' => $token]);

            // Kirim email recovery password lewat email.
            if ($sendEmail) {
                if ($callback) {
                    $callback = $callback . '/change-password/' . $token;
                }

                $messageEmail = 'Hai!<br/><br/>';
                $messageEmail .= 'Sepertinya kamu meminta perubahan password. Satu langkah lagi, silahkan mengklik tautan dibawah ini!<br/>';
                $messageEmail .= '<a href="' . $callback . '">' . $callback . '</a>';
                $messageEmail .= '<br/><br/>Salam,<br/>RuangAI';

                $Heroic->sendEmail($email, 'RuangAI Info - Reset Password', $messageEmail);

                return [
                    'status'  => 'success',
                    'message' => 'Tautan untuk mengganti password sudah dikirim ke Email. Cek folder spam apabila tidak ada Email yang masuk.',
                ];
            }
        }

        return [
            'status'  => 'failed',
            'message' => 'Akun tidak terdaftar.',
        ];
    }

    public function resetPassword($token, $password)
    {
        $userModel = new UserModel();
        $user      = $userModel->where('token', $token)->where('deleted_at', null)->first();

        if ($user) {
            $Phpass   = new \App\Libraries\Phpass();
            $password = $Phpass->HashPassword(trim($password));

            $userModel->update($user['id'], ['pwd' => $password, 'token' => null]);

            return [
                'status'  => 'success',
                'message' => 'Password berhasil diubah.',
            ];
        }

        return [
            'status'  => 'failed',
            'message' => 'Akun tidak terdaftar atau OTP expired.',
        ];
    }

    public function generateActivationToken()
    {
        return bin2hex(random_bytes(15));
    }
}
