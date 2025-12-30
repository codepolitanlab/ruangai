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

        if ($this->certificateModel->insert($data)) {
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
}
