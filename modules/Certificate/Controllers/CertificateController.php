<?php

namespace Certificate\Controllers;

use Heroicadmin\Controllers\AdminController;
use Certificate\Models\CertificateModel;

class CertificateController extends AdminController
{
    protected $certificateModel;
    protected $db;

    public function __construct()
    {
        $this->certificateModel = new CertificateModel();
        $this->db = \Config\Database::connect();

        $this->data['page_title'] = 'Kelola Sertifikat';
        $this->data['module']     = 'certificate';
        $this->data['submodule']  = 'certificate';
    }

    /**
     * List all certificates with pagination and filters
     */
    public function index()
    {
        $perPage = 20;
        $page = $this->request->getVar('page') ?? 1;
        
        // Filters
        $search = $this->request->getVar('search');
        $entityType = $this->request->getVar('entity_type');
        $status = $this->request->getVar('status');

        $builder = $this->db->table('certificates')
            ->select('certificates.*, users.name as user_name, users.email')
            ->join('users', 'users.id = certificates.user_id', 'left')
            ->orderBy('certificates.created_at', 'DESC');

        // Apply filters
        if ($search) {
            $builder->groupStart()
                ->like('certificates.cert_code', $search)
                ->orLike('certificates.participant_name', $search)
                ->orLike('certificates.title', $search)
                ->orLike('users.name', $search)
                ->groupEnd();
        }

        if ($entityType) {
            $builder->where('certificates.entity_type', $entityType);
        }

        if ($status !== null && $status !== '') {
            $builder->where('certificates.is_active', $status);
        }

        $total = $builder->countAllResults(false);
        $certificates = $builder->limit($perPage, ($page - 1) * $perPage)->get()->getResultArray();

        $data = [
            'title' => 'Kelola Sertifikat',
            'certificates' => $certificates,
            'pager' => [
                'total' => $total,
                'perPage' => $perPage,
                'currentPage' => $page,
                'totalPages' => ceil($total / $perPage)
            ],
            'filters' => [
                'search' => $search,
                'entity_type' => $entityType,
                'status' => $status
            ]
        ];

        $this->data = array_merge($this->data, $data);
        return view('Certificate\Views\index', $this->data);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $data = [
            'title' => 'Buat Sertifikat Baru',
            'entity_types' => $this->getEntityTypes(),
            'templates' => $this->getTemplates(),
        ];

        $this->data = array_merge($this->data, $data);
        return view('Certificate\Views\create', $this->data);
    }

    public function generate()
    {
        $data = [
            'title'        => 'Generate Sertifikat',
            'entity_types' => $this->getEntityTypes(),
            'templates'    => $this->getTemplates(),
        ];

        $this->data = array_merge($this->data, $data);
        return view('Certificate\Views\generate', $this->data);
    }

    public function doGenerate()
    {
        $rules = [
            'entity_type'   => 'required',
            'entity_id'     => 'required|integer',
            'template_name' => 'required',
            'title'         => 'required|max_length[500]',
            'emails'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $entityType    = $this->request->getPost('entity_type');
        $entityId      = (int) $this->request->getPost('entity_id');
        $templateName  = $this->request->getPost('template_name');
        $title         = $this->request->getPost('title');
        $emailsRaw     = $this->request->getPost('emails');
        $certClaimDate = date('Y-m-d H:i:s');

        // Validate template exists
        $templateLibrary = new \Certificate\Libraries\CertificateTemplateLibrary();
        if (!$templateLibrary->hasTemplate($templateName)) {
            return redirect()->back()->withInput()->with('error', 'Template tidak ditemukan');
        }

        // Parse email list
        $emails = array_filter(
            array_map('trim', preg_split('/[\r\n,]+/', $emailsRaw)),
            fn($e) => $e !== ''
        );

        if (empty($emails)) {
            return redirect()->back()->withInput()->with('error', 'Tidak ada email yang valid');
        }

        $results  = [];
        $success  = 0;
        $failed   = 0;
        $notFoundEmails = []; // Array untuk menyimpan email yang user not found

        foreach ($emails as $email) {
            // Find user by email
            $user = $this->db->table('users')
                ->select('id, name')
                ->where('email', $email)
                ->get()
                ->getRowArray();

            if (!$user) {
                $results[] = ['email' => $email, 'status' => 'failed', 'message' => 'User tidak ditemukan'];
                $notFoundEmails[] = $email; // Hanya simpan yang not found
                $failed++;
                continue;
            }

            // Check for duplicate certificate
            $exists = $this->certificateModel
                ->where('user_id', $user['id'])
                ->where('entity_type', $entityType)
                ->where('entity_id', $entityId)
                ->first();

            if ($exists) {
                $results[] = ['email' => $email, 'status' => 'skipped', 'message' => 'Sertifikat sudah ada (' . $exists['cert_code'] . ')'];
                $failed++;
                continue;
            }

            $year              = date('Y');
            $nextCertIncrement = $this->certificateModel->getNextCertIncrement($entityType, $year);

            $certificateData = [
                'cert_increment'  => $nextCertIncrement,
                'cert_claim_date' => $certClaimDate,
                'user_id'         => $user['id'],
                'entity_type'     => $entityType,
                'entity_id'       => $entityId,
                'participant_name' => $user['name'],
                'title'           => $title,
                'template_name'   => $templateName,
                'additional_data' => [],
                'is_active'       => 1,
            ];

            if ($this->certificateModel->createCertificate($certificateData)) {
                $results[] = ['email' => $email, 'status' => 'success', 'message' => 'Sertifikat berhasil dibuat untuk ' . esc($user['name'])];
                $success++;
            } else {
                $results[] = ['email' => $email, 'status' => 'failed', 'message' => 'Gagal menyimpan sertifikat'];
                $failed++;
            }
        }

        session()->setFlashdata('generate_results', $results);
        session()->setFlashdata('generate_summary', [
            'total'   => count($emails),
            'success' => $success,
            'failed'  => $failed,
        ]);
        session()->setFlashdata('not_found_emails', $notFoundEmails);

        return redirect()->to(admin_url() . 'certificates/generate')->withInput();
    }

    /**
     * Store new certificate
     */
    public function store()
    {
        $rules = [
            'user_id' => 'required|integer',
            'entity_type' => 'required',
            'entity_id' => 'required|integer',
            'participant_name' => 'required|max_length[255]',
            'title' => 'required|max_length[500]',
            'template_name' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $additionalData = [];
        
        // Parse additional data if exists
        if ($this->request->getPost('additional_data')) {
            $additionalData = json_decode($this->request->getPost('additional_data'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()->withInput()->with('error', 'Format JSON additional data tidak valid');
            }
        }

        $data = [
            'user_id' => $this->request->getPost('user_id'),
            'entity_type' => $this->request->getPost('entity_type'),
            'entity_id' => $this->request->getPost('entity_id'),
            'participant_name' => $this->request->getPost('participant_name'),
            'title' => $this->request->getPost('title'),
            'template_name' => $this->request->getPost('template_name'),
            'additional_data' => json_encode($additionalData),
            'cert_claim_date' => date('Y-m-d H:i:s'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->certificateModel->createCertificate($data)) {
            return redirect()->to('/admin/certificates')->with('success', 'Sertifikat berhasil dibuat');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal membuat sertifikat');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $certificate = $this->certificateModel->find($id);

        if (!$certificate) {
            return redirect()->to('/admin/certificates')->with('error', 'Sertifikat tidak ditemukan');
        }

        // Parse additional_data JSON
        if ($certificate['additional_data']) {
            $certificate['additional_data_json'] = json_encode(json_decode($certificate['additional_data']), JSON_PRETTY_PRINT);
        }

        $data = [
            'title' => 'Edit Sertifikat',
            'certificate' => $certificate,
            'entity_types' => $this->getEntityTypes(),
            'templates' => $this->getTemplates(),
        ];

        $this->data = array_merge($this->data, $data);
        return view('Certificate\Views\edit', $this->data);
    }

    /**
     * Update certificate
     */
    public function update($id)
    {
        $certificate = $this->certificateModel->find($id);

        if (!$certificate) {
            return redirect()->to('/admin/certificates')->with('error', 'Sertifikat tidak ditemukan');
        }

        $rules = [
            'entity_type' => 'required',
            'entity_id' => 'required|integer',
            'participant_name' => 'required|max_length[255]',
            'title' => 'required|max_length[500]',
            'template_name' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $additionalData = [];
        
        // Parse additional data if exists
        if ($this->request->getPost('additional_data')) {
            $additionalData = json_decode($this->request->getPost('additional_data'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()->withInput()->with('error', 'Format JSON additional data tidak valid');
            }
        }

        $data = [
            'entity_type' => $this->request->getPost('entity_type'),
            'entity_id' => $this->request->getPost('entity_id'),
            'participant_name' => $this->request->getPost('participant_name'),
            'title' => $this->request->getPost('title'),
            'template_name' => $this->request->getPost('template_name'),
            'additional_data' => json_encode($additionalData),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->certificateModel->update($id, $data)) {
            return redirect()->to('/admin/certificates')->with('success', 'Sertifikat berhasil diupdate');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal mengupdate sertifikat');
    }

    /**
     * Delete certificate
     */
    public function delete($id)
    {
        $certificate = $this->certificateModel->find($id);

        if (!$certificate) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sertifikat tidak ditemukan']);
        }

        if ($this->certificateModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Sertifikat berhasil dihapus']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus sertifikat']);
    }

    /**
     * View certificate details
     */
    public function view($id)
    {
        $certificate = $this->db->table('certificates')
            ->select('certificates.*, users.name as user_name, users.email, users.phone')
            ->join('users', 'users.id = certificates.user_id', 'left')
            ->where('certificates.id', $id)
            ->get()
            ->getRowArray();

        if (!$certificate) {
            return redirect()->to('/admin/certificates')->with('error', 'Sertifikat tidak ditemukan');
        }

        // Parse additional_data
        if ($certificate['additional_data']) {
            $certificate['additional_data_parsed'] = json_decode($certificate['additional_data'], true);
        }

        $data = [
            'title' => 'Detail Sertifikat',
            'certificate' => $certificate,
        ];

        $this->data = array_merge($this->data, $data);
        return view('Certificate\Views\view', $this->data);
    }

    /**
     * Toggle certificate status (active/inactive)
     */
    public function toggleStatus($id)
    {
        $certificate = $this->certificateModel->find($id);

        if (!$certificate) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sertifikat tidak ditemukan']);
        }

        $newStatus = $certificate['is_active'] ? 0 : 1;

        if ($this->certificateModel->update($id, ['is_active' => $newStatus])) {
            $statusText = $newStatus ? 'aktif' : 'nonaktif';
            return $this->response->setJSON(['success' => true, 'message' => "Sertifikat berhasil di{$statusText}kan", 'status' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengubah status']);
    }

    /**
     * Show Codepolitan certificate generation form
     */
    public function generateCodepolitan()
    {
        $data = [
            'title' => 'Generate Sertifikat via Codepolitan',
        ];

        $this->data = array_merge($this->data, $data);
        return view('Certificate\Views\generate', $this->data);
    }

    /**
     * Process Codepolitan certificate generation — reads name & email from uploaded CSV,
     * hits Codepolitan API directly without any local DB lookup.
     */
    public function doGenerateCodepolitan()
    {
        // Prevent PHP timeout when processing large CSV files
        set_time_limit(0);

        $rules = [
            'template_name' => 'required',
            'title'         => 'required|max_length[500]',
            'csv_file'      => 'uploaded[csv_file]|ext_in[csv_file,csv]|max_size[csv_file,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('cp_errors', $this->validator->getErrors());
        }

        $entityId     = $this->request->getPost('entity_id') ?: null;
        $templateName = $this->request->getPost('template_name');
        $title        = $this->request->getPost('title');

        // Parse CSV — expects header row with "name" and "email" columns
        $file    = $this->request->getFile('csv_file');
        $handle  = fopen($file->getTempName(), 'r');
        $headers = array_map('strtolower', array_map('trim', fgetcsv($handle)));

        $nameIdx  = array_search('name', $headers);
        $emailIdx = array_search('email', $headers);

        if ($nameIdx === false || $emailIdx === false) {
            fclose($handle);
            return redirect()->back()->withInput()->with('cp_error', 'CSV harus memiliki kolom "name" dan "email"');
        }

        $participants = [];
        while (($row = fgetcsv($handle)) !== false) {
            $name  = trim($row[$nameIdx] ?? '');
            $email = strtolower(trim($row[$emailIdx] ?? ''));
            if ($name !== '' && $email !== '') {
                $participants[] = compact('name', 'email');
            }
        }
        fclose($handle);

        if (empty($participants)) {
            return redirect()->back()->withInput()->with('cp_error', 'Tidak ada data peserta yang valid di CSV');
        }

        $results = [];
        $success = 0;
        $failed  = 0;

        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://app.codepolitan.com',
            'timeout'  => 10,
            'headers'  => [
                'Client-Code' => 'DH',
                'Appkey'      => '03ccebe8b6db653c255b6ec0e2097600f56cccf9b58bcdd8fc65f092611c67bf',
            ],
        ]);

        foreach ($participants as $p) {
            try {
                $response = $client->post('/api/certificate/generate', [
                    'form_params' => [
                        'entity_id'         => 1,
                        'entity_type'       => 'scholarship',
                        'participant_name'  => $p['name'],
                        'participant_email' => $p['email'],
                        'title'             => $title,
                        'template_name'     => $templateName,
                    ],
                ]);

                $result = json_decode($response->getBody()->getContents(), true);

                if (empty($result) || ($result['status'] ?? '') !== 'success') {
                    $results[] = ['name' => $p['name'], 'email' => $p['email'], 'status' => 'failed', 'message' => $result['message'] ?? 'Unknown error dari Codepolitan'];
                    $failed++;
                    continue;
                }

                $results[] = ['name' => $p['name'], 'email' => $p['email'], 'status' => 'success', 'message' => 'Berhasil'];
                $success++;

            } catch (\GuzzleHttp\Exception\RequestException $e) {
                $msg = $e->hasResponse()
                    ? 'HTTP ' . $e->getResponse()->getStatusCode() . ': ' . $e->getResponse()->getBody()->getContents()
                    : $e->getMessage();
                $results[] = ['name' => $p['name'], 'email' => $p['email'], 'status' => 'failed', 'message' => $msg];
                $failed++;
            }
        }

        session()->setFlashdata('cp_generate_results', $results);
        session()->setFlashdata('cp_generate_summary', [
            'total'   => count($participants),
            'success' => $success,
            'failed'  => $failed,
        ]);

        return redirect()->to(admin_url() . 'certificates/generate-codepolitan');
    }

    /**
     * Get available entity types
     */
    private function getEntityTypes()
    {
        $config = config('Certificate');
        return $config->certificateTypes;
    }

    /**
     * Get available templates
     */
    private function getTemplates()
    {
        $templateLibrary = new \Certificate\Libraries\CertificateTemplateLibrary();
        $templates = $templateLibrary->getAllTemplates();
        
        $result = [];
        foreach ($templates as $template) {
            $result[$template->getName()] = $template->getDescription();
        }
        
        return $result;
    }
}
