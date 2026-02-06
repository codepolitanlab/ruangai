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
            
            // Cari peserta berdasarkan email di scholarship_participants dan join dengan course_students
            $participant = $db->table('scholarship_participants sp')
                             ->select('sp.*, cs.graduate')
                             ->join('course_students cs', 'cs.user_id = sp.user_id', 'left')
                             ->where('sp.email', $email)
                             ->get()
                             ->getRowArray();

            if ($participant) {
                // Cek apakah peserta belum lulus (graduate = 0 atau NULL)
                if ($participant['graduate'] != 0 && !is_null($participant['graduate'])) {
                    $failedCount++;
                    $failedEmails[] = $email . ' (sudah lulus, tidak bisa di-mapping)';
                    continue;
                }
                
                // Cek apakah reference_comentor masih null atau is_reference_followup = 1
                // if (empty($participant['reference_comentor']) || $participant['is_reference_followup'] == 1) {
                    
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
                // } else {
                //     // Peserta sudah punya comentor atau is_reference_followup bukan 1
                //     $failedCount++;
                //     if (!empty($participant['reference_comentor'])) {
                //         $failedEmails[] = $email . ' (sudah memiliki comentor: ' . $participant['reference_comentor'] . ')';
                //     } else {
                //         $failedEmails[] = $email . ' (is_reference_followup bukan 1)';
                //     }
                // }
            } else {
                $failedCount++;
                $failedEmails[] = $email . ' (tidak ditemukan)';
            }
        }

        // Set flash message
        $message = "<strong>Import selesai.</strong><br>";
        $message .= "✓ Berhasil: <strong>{$successCount}</strong> data<br>";
        $message .= "✗ Gagal: <strong>{$failedCount}</strong> data";
        
        if (!empty($failedEmails)) {
            $message .= "<br><br><strong>Detail Email yang Gagal:</strong><ul style='margin-top: 10px; margin-bottom: 0;'>";
            foreach ($failedEmails as $failedEmail) {
                $message .= "<li>" . htmlspecialchars($failedEmail) . "</li>";
            }
            $message .= "</ul>";
        }

        if ($successCount > 0) {
            session()->setFlashdata('success', $message);
        } else {
            session()->setFlashdata('error', $message);
        }

        return redirect()->to('/'.urlScope().'/scholarship/followup-comentors/'.$userId.'/detail');
    }
}
