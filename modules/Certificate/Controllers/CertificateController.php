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
        $failedEmails = []; // Array untuk menyimpan email yang gagal

        foreach ($emails as $email) {
            // Find user by email
            $user = $this->db->table('users')
                ->select('id, name')
                ->where('email', $email)
                ->get()
                ->getRowArray();

            if (!$user) {
                $results[] = ['email' => $email, 'status' => 'failed', 'message' => 'User tidak ditemukan'];
                $failedEmails[] = $email;
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
                $failedEmails[] = $email;
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
                $failedEmails[] = $email;
                $failed++;
            }
        }

        session()->setFlashdata('generate_results', $results);
        session()->setFlashdata('generate_summary', [
            'total'   => count($emails),
            'success' => $success,
            'failed'  => $failed,
        ]);
        session()->setFlashdata('failed_emails', $failedEmails);

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

    /**
     * Download failed emails as CSV
     */
    public function downloadFailedEmails()
    {
        $failedEmails = session()->getFlashdata('failed_emails');
        
        if (!$failedEmails || empty($failedEmails)) {
            return redirect()->to(admin_url() . 'certificates/generate')
                ->with('error', 'Tidak ada data email yang gagal untuk diunduh');
        }

        // Generate CSV content
        $filename = 'failed-emails-' . date('Y-m-d-His') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, ['Email', 'Tanggal Generate']);
        
        // Data rows
        foreach ($failedEmails as $email) {
            fputcsv($output, [$email, date('Y-m-d H:i:s')]);
        }
        
        fclose($output);
        exit;
    }
}
