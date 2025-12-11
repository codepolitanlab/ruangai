<?php

namespace Scholarship\Controllers;

use Heroicadmin\Controllers\AdminController;
use App\Models\UserModel;

class FollowupComentors extends AdminController
{
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->data['page_title'] = 'Followup Comentor';
        $this->data['module']     = 'scholarship';
        $this->data['submodule']  = 'followup_comentors';
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        // Query untuk mendapatkan daftar comentor dengan total followup dari view_participants
        $builder = $db->table('users u');
        $builder->select('u.id, u.name, u.email, u.phone, 
                         COUNT(vp.id) as total_followup,
                         vp_comentor.referral_code_comentor')
                ->join('view_participants vp_comentor', 'vp_comentor.user_id = u.id', 'left')
                ->join('view_participants vp', 
                       'vp.reference_comentor = vp_comentor.referral_code_comentor 
                        AND vp.is_reference_followup = 1 
                        AND vp.graduate = 0', 
                       'left')
                ->where('u.role_id', 4)
                ->where('u.deleted_at', null)
                ->groupBy('u.id, u.name, u.email, u.phone, vp_comentor.referral_code_comentor')
                ->orderBy('total_followup', 'DESC');
        
        $query = $builder->get();
        $comentors = $query->getResultArray();
        
        $this->data['comentors'] = $comentors;
        
        return view('Scholarship\Views\followup_comentors\index', $this->data);
    }

    public function detail($userId = null)
    {
        if (!$userId) {
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors');
        }

        $db = \Config\Database::connect();
        
        // Get comentor info
        $userModel = new UserModel();
        $comentor = $userModel->find($userId);
        
        if (!$comentor || $comentor['role_id'] != 4) {
            session()->setFlashdata('error', 'Comentor tidak ditemukan');
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors');
        }

        // Get referral code comentor dari view_participants
        $builderComentorCode = $db->table('view_participants');
        $builderComentorCode->select('referral_code_comentor')
                            ->where('user_id', $userId)
                            ->limit(1);
        
        $comentorData = $builderComentorCode->get()->getRowArray();
        
        if (!$comentorData || !$comentorData['referral_code_comentor']) {
            session()->setFlashdata('error', 'Referral code comentor tidak ditemukan');
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors');
        }

        // Query untuk mendapatkan daftar peserta followup dari view_participants
        $builder = $db->table('view_participants vp');
        $builder->select('vp.*')
                ->where('vp.reference_comentor', $comentorData['referral_code_comentor'])
                ->where('vp.is_reference_followup', 1)
                ->where('vp.graduate', 0)
                ->orderBy('vp.tanggal_daftar', 'DESC');
        
        $query = $builder->get();
        $followups = $query->getResultArray();
        
        $this->data['comentor'] = $comentor;
        $this->data['comentor_code'] = $comentorData['referral_code_comentor'];
        $this->data['followups'] = $followups;
        $this->data['total_followup'] = count($followups);
        
        return view('Scholarship\Views\followup_comentors\detail', $this->data);
    }

    public function import($userId = null)
    {
        if (!$userId) {
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors');
        }

        $db = \Config\Database::connect();
        
        // Get comentor info
        $userModel = new UserModel();
        $comentor = $userModel->find($userId);
        
        if (!$comentor || $comentor['role_id'] != 4) {
            session()->setFlashdata('error', 'Comentor tidak ditemukan');
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors');
        }

        // Get referral code comentor
        $builderComentorCode = $db->table('view_participants');
        $builderComentorCode->select('referral_code_comentor')
                            ->where('user_id', $userId)
                            ->limit(1);
        
        $comentorData = $builderComentorCode->get()->getRowArray();
        
        if (!$comentorData || !$comentorData['referral_code_comentor']) {
            session()->setFlashdata('error', 'Referral code comentor tidak ditemukan');
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors');
        }

        $this->data['comentor'] = $comentor;
        $this->data['comentor_code'] = $comentorData['referral_code_comentor'];
        
        return view('Scholarship\Views\followup_comentors\import', $this->data);
    }

    public function processImport($userId = null)
    {
        if (!$userId) {
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors');
        }

        $db = \Config\Database::connect();
        
        // Get comentor info
        $userModel = new UserModel();
        $comentor = $userModel->find($userId);
        
        if (!$comentor || $comentor['role_id'] != 4) {
            session()->setFlashdata('error', 'Comentor tidak ditemukan');
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors');
        }

        // Get referral code comentor
        $builderComentorCode = $db->table('scholarship_participants');
        $builderComentorCode->select('referral_code_comentor')
                            ->where('user_id', $userId)
                            ->limit(1);
        
        $comentorData = $builderComentorCode->get()->getRowArray();
        
        if (!$comentorData || !$comentorData['referral_code_comentor']) {
            session()->setFlashdata('error', 'Referral code comentor tidak ditemukan');
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors/'.$userId.'/import');
        }

        // Validasi file upload
        $file = $this->request->getFile('csv_file');
        
        if (!$file || !$file->isValid()) {
            session()->setFlashdata('error', 'File CSV tidak valid');
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors/'.$userId.'/import');
        }

        // Validasi extension
        if ($file->getExtension() != 'csv') {
            session()->setFlashdata('error', 'File harus berformat CSV');
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors/'.$userId.'/import');
        }

        // Read CSV file
        $csvData = array_map('str_getcsv', file($file->getTempName()));
        
        if (empty($csvData)) {
            session()->setFlashdata('error', 'File CSV kosong');
            return redirect()->to('/'.urlScope().'/scholarship/followup-comentors/'.$userId.'/import');
        }

        // Remove header if exists
        $header = array_shift($csvData);
        
        $successCount = 0;
        $failedCount = 0;
        $failedEmails = [];

        foreach ($csvData as $row) {
            if (empty($row[0])) {
                continue;
            }

            $email = trim($row[0]);
            
            // Cari peserta berdasarkan email di scholarship_participants
            $participant = $db->table('scholarship_participants')
                             ->where('email', $email)
                             ->get()
                             ->getRowArray();

            if ($participant) {
                // Cek apakah reference_comentor masih null dan is_reference_followup masih 0 atau null
                if (empty($participant['reference_comentor']) && 
                    (empty($participant['is_reference_followup']) || $participant['is_reference_followup'] == 0)) {
                    
                    // Update data peserta dengan kode comentor
                    $updateData = [
                        'reference_comentor' => $comentorData['referral_code_comentor'],
                        'is_reference_followup' => 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $updated = $db->table('scholarship_participants')
                                 ->where('id', $participant['id'])
                                 ->update($updateData);

                    if ($updated) {
                        $successCount++;
                    } else {
                        $failedCount++;
                        $failedEmails[] = $email . ' (gagal update)';
                    }
                } else {
                    // Peserta sudah punya comentor atau sudah di-followup
                    $failedCount++;
                    $failedEmails[] = $email . ' (sudah memiliki comentor)';
                }
            } else {
                $failedCount++;
                $failedEmails[] = $email . ' (tidak ditemukan)';
            }
        }

        // Set flash message
        $message = "Import selesai. Berhasil: {$successCount}, Gagal: {$failedCount}";
        
        if (!empty($failedEmails)) {
            $message .= "<br>Email gagal: " . implode(', ', array_slice($failedEmails, 0, 10));
            if (count($failedEmails) > 10) {
                $message .= " dan " . (count($failedEmails) - 10) . " lainnya";
            }
        }

        if ($successCount > 0) {
            session()->setFlashdata('success', $message);
        } else {
            session()->setFlashdata('error', $message);
        }

        return redirect()->to('/'.urlScope().'/scholarship/followup-comentors/'.$userId.'/detail');
    }
}
