<?php

namespace App\Controllers\Api;

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
        $data = 'asd';
        return $this->response->setJSON($data);
    }

    public function register()
    {
        $data = $this->request->getPost();

        // Validasi minimum
        if (!isset($data['phone'], $data['name'], $data['email'])) {
            return $this->failValidationErrors(['message' => 'Data tidak lengkap.']);
        }

        $userModel = new UserModel();
        $userId = $userModel->insert([
            'name'     => $data['name'],
            'username' => $data['name'] . '123',
            'email'    => $data['email'],
            'phone'    => $data['phone'],
        ]);
        $data['user_id'] = $userId;

        $participantModel = new ScholarshipParticipantModel();
        $participantModel->insert($data);

        return $this->respondCreated(['status' => 'success', 'message' => 'Registrasi berhasil, selamat anda telah mendapatkan Beasiswa RuangAI.']);
    }

}