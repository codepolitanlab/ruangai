<?php

namespace App\Controllers\Api;

use App\Models\OtpWhatsappModel;
use App\Models\ScholarshipParticipantModel;
use App\Models\UserModel;
use App\Models\UserProfile;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    use ResponseTrait;

    protected $db;
    protected $user_profile = 'user_profiles';
    protected $format = 'json';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function saveProfile()
    {
        $data = $this->request->getPost();

        // Check table users by user jwt
        $jwt = $this->checkToken();

        $userModel = new UserModel();
        $user = $userModel->where('phone', $jwt->whatsapp_number)->first();
        
        if (!$user) {
            return $this->fail(['status' => 'failed', 'message' => 'Pengguna tidak ditemukan.']);
        }
        
        // Insert or Update data on profile
        $userProfileModel = new UserProfile();
        $userProfile = $userProfileModel->where('user_id', $user['id'])->first();

        if ($userProfile) {
            $userProfileModel->update($userProfile['id'], [
                'bank_name'    => $data['bank_name'],
                'bank_account' => $data['bank_account'],
                'bank_code'    => $data['bank_code'],
            ]);
        } else {
            $userProfileModel->insert([
                'user_id'      => $user['id'],
                'bank_name'    => $data['bank_name'],
                'bank_account' => $data['bank_account'],
                'bank_code'    => $data['bank_code'],
            ]);
        }

        return $this->respond(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
    }

    public function checkToken()
    {
        $Heroic = new \App\Libraries\Heroic();
        return $Heroic->checkToken();
    }

}
