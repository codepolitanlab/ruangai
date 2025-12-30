<?php

namespace Event\Controllers;

use App\Controllers\BaseController;
use Heroicadmin\Modules\Entry\Entry;
use Symfony\Component\Yaml\Yaml;

class Event extends BaseController
{
    protected $Entry;
    protected $db;
    
    public function __construct()
    {
        $this->Entry = new Entry(Yaml::parseFile(__DIR__ . '/../Entries/event.yml'));
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        if ($this->request->getGet('tableBody')) {
            return $this->Entry->tableBody();
        }
        
        return $this->Entry->index();
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            
            // Generate slug dari title jika kosong
            if (empty($data['slug'])) {
                $data['slug'] = url_title($data['title'], '-', true);
            }
            
            // Set created_by ke user yang login
            if (empty($data['created_by']) && session()->has('user_id')) {
                $data['created_by'] = session()->get('user_id');
            }
            
            // Handle file upload
            $data = $this->handleFileUploads($data);
            
            $result = $this->Entry->insert($data);
            
            if ($result) {
                return redirect()->to(base_url('heroic/event'))
                    ->with('success', 'Event berhasil ditambahkan');
            }
            
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->Entry->errors());
        }
        
        return $this->Entry->create();
    }

    public function edit($id)
    {
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            
            // Generate slug dari title jika kosong
            if (empty($data['slug'])) {
                $data['slug'] = url_title($data['title'], '-', true);
            }
            
            // Handle file upload
            $data = $this->handleFileUploads($data, $id);
            
            $result = $this->Entry->update($id, $data);
            
            if ($result) {
                return redirect()->to(base_url('heroic/event'))
                    ->with('success', 'Event berhasil diupdate');
            }
            
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->Entry->errors());
        }
        
        return $this->Entry->edit($id);
    }

    public function delete($id)
    {
        $result = $this->Entry->delete($id);
        
        if ($result) {
            return redirect()->to(base_url('heroic/event'))
                ->with('success', 'Event berhasil dihapus');
        }
        
        return redirect()->back()
            ->with('error', 'Gagal menghapus event');
    }

    /**
     * Halaman peserta event
     */
    public function participants($eventId)
    {
        $event = $this->db->table('events')->where('id', $eventId)->get()->getRowArray();
        
        if (!$event) {
            return redirect()->to(base_url('heroic/event'))
                ->with('error', 'Event tidak ditemukan');
        }
        
        $participants = $this->db->table('event_participants')
            ->select('event_participants.*, users.name, users.email')
            ->join('users', 'users.id = event_participants.user_id')
            ->where('event_participants.event_id', $eventId)
            ->orderBy('event_participants.registration_date', 'DESC')
            ->get()
            ->getResultArray();
        
        return view('Event\Views\participants', [
            'event' => $event,
            'participants' => $participants,
        ]);
    }

    /**
     * Tambah peserta event
     */
    public function addParticipant($eventId)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        $userId = $this->request->getPost('user_id');
        
        // Cek apakah user sudah terdaftar
        $exists = $this->db->table('event_participants')
            ->where('event_id', $eventId)
            ->where('user_id', $userId)
            ->countAllResults() > 0;
        
        if ($exists) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User sudah terdaftar pada event ini'
            ]);
        }
        
        // Cek kuota
        $event = $this->db->table('events')->where('id', $eventId)->get()->getRowArray();
        if ($event && $event['max_participants']) {
            $currentCount = $this->db->table('event_participants')
                ->where('event_id', $eventId)
                ->where('attendance_status !=', 'cancelled')
                ->countAllResults();
            
            if ($currentCount >= $event['max_participants']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kuota peserta sudah penuh'
                ]);
            }
        }
        
        $data = [
            'event_id' => $eventId,
            'user_id' => $userId,
            'registration_date' => date('Y-m-d H:i:s'),
            'attendance_status' => 'registered',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        
        $result = $this->db->table('event_participants')->insert($data);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Peserta berhasil ditambahkan'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menambahkan peserta'
        ]);
    }

    /**
     * Update status kehadiran
     */
    public function updateAttendance($participantId)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        $status = $this->request->getPost('status');
        $data = [
            'attendance_status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        if ($status === 'attended') {
            $data['check_in_time'] = date('Y-m-d H:i:s');
        }
        
        $result = $this->db->table('event_participants')
            ->where('id', $participantId)
            ->update($data);
        
        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status kehadiran berhasil diupdate'
            ]);
        }
        
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengupdate status kehadiran'
        ]);
    }

    /**
     * Issue sertifikat untuk peserta
     */
    public function issueCertificate($participantId)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }
        
        $participant = $this->db->table('event_participants')
            ->select('event_participants.*, events.*, users.name as participant_name')
            ->join('events', 'events.id = event_participants.event_id')
            ->join('users', 'users.id = event_participants.user_id')
            ->where('event_participants.id', $participantId)
            ->get()
            ->getRowArray();
        
        if (!$participant) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Peserta tidak ditemukan'
            ]);
        }
        
        // Cek apakah event punya sertifikat
        if (!$participant['has_certificate']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Event ini tidak menerbitkan sertifikat'
            ]);
        }
        
        // Cek apakah wajib hadir
        if ($participant['attendance_required'] && $participant['attendance_status'] !== 'attended') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Peserta harus hadir untuk mendapat sertifikat'
            ]);
        }
        
        // Cek apakah sudah ada sertifikat
        if ($participant['certificate_issued']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Sertifikat sudah pernah diterbitkan'
            ]);
        }
        
        // Generate certificate code
        $certCode = 'CERT-' . strtoupper(uniqid());
        
        // Insert ke tabel certificates
        $certData = [
            'cert_code' => $certCode,
            'user_id' => $participant['user_id'],
            'entity_type' => 'event',
            'entity_id' => $participant['event_id'],
            'participant_name' => $participant['participant_name'],
            'title' => $participant['title'],
            'template_name' => $participant['certificate_template'] ?? 'default',
            'is_active' => 1,
            'cert_claim_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        
        $this->db->table('certificates')->insert($certData);
        $certificateId = $this->db->insertID();
        
        // Update event_participants
        $this->db->table('event_participants')
            ->where('id', $participantId)
            ->update([
                'certificate_issued' => 1,
                'certificate_id' => $certificateId,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Sertifikat berhasil diterbitkan',
            'certificate_id' => $certificateId,
            'cert_code' => $certCode,
        ]);
    }

    /**
     * Handle file uploads
     */
    private function handleFileUploads($data, $id = null)
    {
        $uploadPath = FCPATH . 'uploads/events/';
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Handle thumbnail
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail && $thumbnail->isValid()) {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move($uploadPath, $thumbnailName);
            $data['thumbnail'] = 'uploads/events/' . $thumbnailName;
            
            // Hapus file lama jika update
            if ($id) {
                $oldData = $this->db->table('events')->where('id', $id)->get()->getRowArray();
                if ($oldData && $oldData['thumbnail'] && file_exists(FCPATH . $oldData['thumbnail'])) {
                    unlink(FCPATH . $oldData['thumbnail']);
                }
            }
        }
        
        // Handle banner
        $banner = $this->request->getFile('banner');
        if ($banner && $banner->isValid()) {
            $bannerName = $banner->getRandomName();
            $banner->move($uploadPath, $bannerName);
            $data['banner'] = 'uploads/events/' . $bannerName;
            
            // Hapus file lama jika update
            if ($id) {
                $oldData = $this->db->table('events')->where('id', $id)->get()->getRowArray();
                if ($oldData && $oldData['banner'] && file_exists(FCPATH . $oldData['banner'])) {
                    unlink(FCPATH . $oldData['banner']);
                }
            }
        }
        
        return $data;
    }

    /**
     * Halaman sesi event
     */
    public function sessions($eventId)
    {
        $event = $this->db->table('events')->where('id', $eventId)->get()->getRowArray();
        
        if (!$event) {
            return redirect()->to(base_url('heroic/event'))
                ->with('error', 'Event tidak ditemukan');
        }
        
        $sessions = $this->db->table('event_sessions')
            ->where('event_id', $eventId)
            ->orderBy('session_order', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->get()
            ->getResultArray();
        
        return view('Event\Views\sessions', [
            'event' => $event,
            'sessions' => $sessions,
        ]);
    }
}
