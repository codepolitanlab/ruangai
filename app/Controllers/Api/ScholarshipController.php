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
            'phone_valid' => 1
        ]);

        // if failed insert users
        if (!$userId) {
            return $this->fail(['status' => 'failed', 'message' => 'Registrasi gagal.']);
        }

        $data['user_id'] = $userId;
        $data['whatsapp'] = $jwt->whatsapp_number;
        $data['referral_code'] = strtoupper(substr(uniqid(), -6));
        $data['status'] = 'terdaftar';

        $participantModel = new ScholarshipParticipantModel();

        // Check existing by user_id before insert
        $participant = $participantModel->where('user_id', $userId)->where('deleted_at', null)->first();

        if ($participant) {
            return $this->fail(['status' => 'failed', 'message' => 'Beasiswa sudah pernah terdaftar.']);
        }

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

        $memberQuery = $participantModel->select('fullname, status, created_at as joined_at')
            ->where('reference', $leader['referral_code'])
            ->where('deleted_at', null)
            ->get();

        $members = $memberQuery->getResultArray();

        // Filter member graduated by status completed
        $graduated = count(array_filter($members, function ($member) {
            return $member['status'] === 'lulus';
        }));

        $commision = 5000;
        $disbursed = 0;

        $data['referral_code'] = $leader['referral_code'];
        $data['bank'] = $bank;
        $data['members'] = $members;
        $data['total_member'] = $memberQuery->getNumRows();
        $data['total_graduated'] = $graduated;
        $data['total_commission'] = $commision * $graduated;
        $data['total_disbursed'] = $disbursed;

        return $this->respond($data);
    }

    public function program()
    {
        $program = $this->request->getGet('name');

        if ($program === 'RuangAI2025B1') {
            $scholarshipModel = new ScholarshipParticipantModel();
            $eventModel = new \App\Models\Events();

            $masterProgram = $eventModel->where('code', 'RuangAI2025B1')->first();
            $program = $masterProgram['title'];
            $quota = $masterProgram['quota'];
            $quota_used = $scholarshipModel->where('program', 'RuangAI2025B1')->where('deleted_at', null)->countAllResults();
            $graduated = $scholarshipModel->where('program', 'RuangAI2025B1')->where('deleted_at', null)->where('status', 'lulus')->countAllResults();
        }

        $data['program'] = $program;
        $data['quota'] = $quota ?? 0;
        $data['quota_used'] = $quota_used ?? 0;
        $data['quota_left'] = $quota - $graduated;
        $data['graduated'] = $graduated ?? 0;

        return $this->respond($data);
    }
}
