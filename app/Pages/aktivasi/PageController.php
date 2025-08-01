<?php

namespace App\Pages\aktivasi;

use App\Pages\BaseController;
use Firebase\JWT\JWT;

class PageController extends BaseController
{
    // Submit new user
    public function postIndex()
    {
        $token = $this->request->getPost('token');
        $npa   = $this->request->getPost('npa');

        $db = \Config\Database::connect();

        // Cek tahap pertama token dan NPA
        if ($token && $npa) {
            $anggota = $db->table('anggota')
                ->where('npa', trim($npa))
                ->where('token', trim($token))
                ->where('status', '0')
                ->get()->getRowArray();

            if ($anggota) {
                $data['token']    = trim($token);
                $data['username'] = trim($npa);
                $data['id']       = $anggota['id'];
                $jwt              = JWT::encode($data, config('App')->jwtKey['secret'], 'HS256');

                return $this->respond(['found' => 1, 'token' => $jwt]);
            }

            return $this->respond(['found' => 0, 'message' => 'Token tidak valid'], 400);
        }

        if (isset($post['npa'])) {
            $anggota = $db->table('anggota')
                ->where('npa', trim($post['npa']))
                ->get()->row_array();
        }
        // dd($post, $anggota);

        // Set username from email if not provided
        $username = ci()->input->post('username')
                    ?? preg_replace('/[\W]/', '', $post['email']);

        $registerData = [
            'name'             => htmlspecialchars($post['name']),
            'username'         => str_replace('.', '', $anggota['npa']),
            'email'            => htmlspecialchars($post['email']),
            'password'         => ci()->input->post('password'),
            'confirm_password' => ci()->input->post('confirm_password'),
            'role_id'          => 3,
            'referrer_code'    => get_cookie('referrer') ?? '',
        ];
        $profileData = [
            'pw_id'      => $anggota['pw_id'],
            'pd_id'      => $anggota['pd_id'],
            'pc_id'      => $anggota['pc_id'],
            'jobs'       => $anggota['pekerjaan'],
            'birthplace' => $anggota['tempat_lahir'],
            'birthday'   => $anggota['tanggal_lahir'],
        ];

        if (setting_item('user.include_phone_on_register') === 1
            || in_array(setting_item('user.otp_mode'), ['WASender', 'Woowa', 'ZenzivaWA'], true)) {
            $country_code = trim(ci()->input->post('country_code', true));
            $phone        = trim(ci()->input->post('phone', true));
            if (substr($phone, 0, 1) === '0') {
                $phone = substr_replace($phone, '', 0, 1);
            }
            $profileData['phone'] = $country_code . $phone;
        }

        $register = ci()->ci_auth->register($registerData, $profileData ?? []);

        if ($register['status'] === 'success') {
            // Update username untuk NPA
            $db->where('id', $register['id'])->set('username', $anggota['npa'])->update('mein_users');

            // Update status aktivasi
            $db->where('npa', $anggota['npa'])->set('status', 1)->update('anggota');

            // Inisiasi Tagihan
            $this->initTagihan($register['id']);

            // Force login, send link activation to email for later activation
            if (setting_item('user.allow_login_before_activation')) {
                $this->sendActivationLink($register);
                ci()->ci_auth->forceLogin($register['id']);

                if ($redirect) {
                    ci()->session->unset_userdata('redirect');
                    redirect($redirect);
                }

                redirect('dashboard');

            // Send link activation to email, but cannot login before activation
            } elseif (setting_item('user.confirmation_type') === 'link') {
                $this->sendActivationLink($register);
                ci()->session->set_flashdata('$heroicHelper.toastr', json_encode(['type' => 'primary', 'position' => 'top', 'message' => 'Untuk dapat masuk, segera aktivasi akun dengan mengklik tautan aktivasi yang telah kami kirim ke alamat email.']));
                redirect('auth/login');

            // Use OTP for user to activates immediately
            } else {
                $this->sendOTP($register);
                redirect('auth/register/confirm_otp/' . $register['token']);
            }
        }

        ci()->session->set_flashdata('message', '<div class="alert alert-danger">' . $register['message'] . '</div>');
        redirect('auth/register');
    }

    private function sendActivationLink($data)
    {
        ci()->load->helper('email');
        sendEmail(
            [$data['email'], $data['name']],
            'Konfirmasi Registrasi',
            $data,
            null,
            ci()->load->render('pages/auth/register/email_link.html', $data, true)
        );
    }

    private function sendOTP($data)
    {
        if (setting_item('user.otp_mode') === 'email') {
            ci()->load->helper('email');
            sendEmail(
                [$data['email'], $data['name']],
                'Konfirmasi Registrasi',
                $data,
                null,
                ci()->load->render('pages/auth/register/email_otp.html', $data, true)
            );
        } elseif (in_array(setting_item('user.otp_mode'), ['WASender', 'Woowa', 'ZenzivaWA'], true)) {
            $sender  = new App\modules\notifier\libraries\Sender(setting_item('user.otp_mode'));
            $message = $this->getRandomOTPMessage();
            $message = str_replace('{otp}', $data['otp'], $message);
            $res     = $sender->sendText($data['phone'], $message);
        }
    }

    private function getRandomOTPMessage()
    {
        $firstMessage                 = 'Anda telah mendaftar di aplikasi ' . setting_item('site.site_title') . "\n";
        $message_confirm_register_otp = [
            'Masukkan kode berikut untuk mengkonfirmasi pendaftaran: {otp}',
            'Silakan aktifkan akun Anda dengan memasukkan kode berikut di halaman konfirmasi: {otp}',
            'Satu langkah lagi, masukkan kode berikut untuk mengaktifkan akun: {otp}',
            'Aktifkan akun dengan memasukkan kode berikut ini: {otp}',
            'Terima kasih sudah mendaftar, aktifkan akun dengan memasukkan kode ini: {otp}',
            'Pendaftaran akun berhasil. Silakan aktifkan akun dengan memasukkan kode berikut: {otp}',
        ];

        return $firstMessage . $message_confirm_register_otp[array_rand($message_confirm_register_otp)];
    }

    private function initTagihan($user_id)
    {
        // Get anggota id based on user id
        $anggota = $db->select('anggota.id')
            ->table('anggota')
            ->join('mein_users', 'mein_users.username = anggota.npa')
            ->where('mein_users.id', $user_id)
            ->get()
            ->row_array();

        // Update user_id di tagihan based on anggota.id
        $db->where('anggota_id', $anggota['id'])->set('user_id', $user_id)->update('md_bills');
    }
}
