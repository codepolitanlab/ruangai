<?php

namespace App\Controllers\api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
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

    public function create()
    {
        $rules = [
            'fullname'   => 'required|max_length[255]',
            'program'    => 'required',
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status'   => false,
                'errors'   => $this->validator->getErrors(),
                'message'  => 'Validasi data gagal'
            ];
            return $this->respond($response, 400);
        }

        $data = $this->request->getPost();
        $data['created_at'] = date('Y-m-d H:i:s');
        
        try {
            $builder = $this->db->table($this->table);
            $builder->insert($data);
            $scholarshipId = $this->db->insertID();

            if ($scholarshipId) {
                $response = [
                    'status'   => true,
                    'data'     => ['id' => $scholarshipId],
                    'message'  => 'Data beasiswa berhasil ditambahkan'
                ];
                return $this->respondCreated($response);
            } else {
                $response = [
                    'status'   => false,
                    'message'  => 'Gagal menyimpan data beasiswa'
                ];
                return $this->respond($response);
            }
        } catch (DatabaseException $e) {
            $response = [
                'status'   => false,
                'message'  => 'Terjadi kesalahan database: ' . $e->getMessage()
            ];
            return $this->respond($response);
        }
    }

}