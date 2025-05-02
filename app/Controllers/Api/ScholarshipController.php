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

    public function index()
    {
        $data = 'Test Controller';
        return $this->response->setJSON($data);
    }

    public function register()
    {
        $data = $this->request->getPost();

        // Minimum validate
        if (!isset($data['name'], $data['email'])) {
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
        $userId = $userModel->insert([
            'name'     => $data['name'],
            'username' => $data['name'] . '123',
            'email'    => $data['email'],
            'phone'    => $jwt->whatsapp_number,
        ]);

        $data['user_id'] = $userId;
        $data['whatsapp'] = $jwt->whatsapp_number;

        $participantModel = new ScholarshipParticipantModel();
        $participantModel->insert($data);

        return $this->respondCreated(['status' => 'success', 'message' => 'Registrasi berhasil, selamat anda telah mendapatkan Beasiswa RuangAI.']);
    }

}
