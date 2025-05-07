<?php

namespace App\Controllers\Api;

use App\Models\OtpWhatsappModel;
use App\Models\ScholarshipParticipantModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class ScholarshipController extends ResourceController
{
    use ResponseTrait;

    protected $db;
    protected $table = 'scholarship_participants';
    protected $format = 'json';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function checkToken()
    {
        $Heroic = new \App\Libraries\Heroic();
        return $Heroic->checkToken();
    }

    public function index()
    {
        $data = 'Test Controllers';
        return $this->response->setJSON($data);
    }

    public function register()
    {
        $data = $this->request->getPost();

        // Minimum validate
        if (!isset($data['fullname'], $data['email'])) {
            return $this->failValidationErrors(['message' => 'Mohon untuk melengkapi data.']);
        }

        // Get JWT from headers
        $jwt = $this->checkToken();

        // Compare JWT with data otp_whatsapps
        $otpModel = new OtpWhatsappModel();
        $isRegistered = $otpModel->where('whatsapp_number', $jwt->whatsapp_number)->first();

        if (!$isRegistered) {
            return $this->fail(['status' => 'failed', 'message' => 'Autentikasi gagal.']);
        }

        $userModel = new UserModel();
        // Check if user already registered by email and or where phone
        $user = $userModel->groupStart()
            ->where('email', $data['email'])
            ->orWhere('phone', $jwt->whatsapp_number)
            ->groupEnd()
            ->where('deleted_at', null)
            ->first();

        if ($user) {
            return $this->fail(['status' => 'failed', 'message' => 'Akun sudah pernah terdaftar.']);
        }

        // Get username from fullname, remove space and lowercase all with sufix random
        $username = str_replace(' ', '', strtolower($data['fullname'])) . bin2hex(random_bytes(5));

        $userId = $userModel->insert([
            'name'     => $data['fullname'],
            'username' => $username,
            'email'    => $data['email'],
            'phone'    => $jwt->whatsapp_number,
        ]);

        // if failed insert users
        if (!$userId) {
            return $this->fail(['status' => 'failed', 'message' => 'Registrasi gagal.']);
        }

        $data['user_id'] = $userId;
        $data['whatsapp'] = $jwt->whatsapp_number;
        $data['referral_code'] = strtoupper(substr(uniqid(), -6));

        $participantModel = new ScholarshipParticipantModel();
        $participantModel->insert($data);

        return $this->respondCreated(['status' => 'success', 'message' => 'Registrasi berhasil, selamat anda telah mendapatkan Beasiswa RuangAI.']);
    }

    public function userReferral()
    {
        $jwt = $this->checkToken();
        $participantModel = new ScholarshipParticipantModel();

        $leader = $participantModel
            ->where('whatsapp', $jwt->whatsapp_number)
            ->where('deleted_at', null)
            ->orderBy('created_at', 'DESC')
            ->first();

        if (!$leader) {
            return $this->respond(['status' => 'failed', 'message' => 'Pengguna tidak ditemukan.']);
        }

        // Get data bank from user profile
        $userProfileModel = new \App\Models\UserProfile();
        $profile = $userProfileModel->where('user_id', $leader['user_id'])->where('deleted_at', null)->first();

        // Save bank on type object
        $bank = null;
        if ($profile) {
            $bank = (object) [
                'bank_name'      => $profile['bank_name'],
                'account_name'   => $profile['account_name'],
                'account_number' => $profile['account_number'],
            ];
        }

        $memberQuery = $participantModel->select('fullname, created_at as joined_at')
            ->where('reference', $leader['referral_code'])
            ->where('deleted_at', null)
            ->get();

        $members = $memberQuery->getResultArray();

        $data['referral_code'] = $leader['referral_code'];
        $data['total_member'] = $memberQuery->getNumRows();
        $data['bank'] = $bank;
        $data['members'] = $members;

        return $this->respond($data);
    }
}
