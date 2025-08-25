<?php

namespace App\Controllers\Api;

use App\Models\UserModel;
use App\Models\UserProfile;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class RegionController extends ResourceController
{
    use ResponseTrait;

    protected $db;
    protected $format       = 'json';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function province()
    {
        $builder = $this->db->table('reg_provinces');
        $query = $builder->get();

        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->setJSON($query->getResult());
    }

    public function city($province_id = null)
    {
        if ($province_id === null) {
            return $this->fail('Province ID is required', 400);
        }

        $builder = $this->db->table('reg_regencies');
        $builder->where('province_id', $province_id);
        $query = $builder->get();

        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->setJSON($query->getResult());
    }

    public function district($regency_id = null)
    {
        if ($regency_id === null) {
            return $this->fail('Regency ID is required', 400);
        }

        $builder = $this->db->table('reg_districts');
        $builder->where('regency_id', $regency_id);
        $query = $builder->get();

        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->setJSON($query->getResult());
    }

    public function village($district_id = null)
    {
        if ($district_id === null) {
            return $this->fail('District ID is required', 400);
        }

        $builder = $this->db->table('reg_villages');
        $builder->where('district_id', $district_id);
        $query = $builder->get();

        return $this->response
            ->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->setJSON($query->getResult());
    }
}
