<?php

namespace App\Pages\comentor;

use App\Pages\BaseController;
use Firebase\JWT\JWT;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Co-Mentor',
        'module'      => 'comentor',
        'active_page' => 'comentor',
    ];

    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);
        $this->data['name'] = $jwt->user['name'];

        $db = \Config\Database::connect();

        $participantModel = new \App\Models\ScholarshipParticipantModel();
        $leader = $participantModel
            ->select('scholarship_participants.*, users.role_id')
            ->join('users', 'users.id = scholarship_participants.user_id')
            ->where('scholarship_participants.user_id', $jwt->user_id)
            ->where('scholarship_participants.deleted_at', null)
            ->first();

        $memberQuery = $participantModel->select("
                scholarship_participants.user_id,
                MAX(scholarship_participants.fullname) as fullname,
                MAX(scholarship_participants.whatsapp) as whatsapp,
                MAX(scholarship_participants.email) as email,
                MAX(scholarship_participants.occupation) as occupation,
                MAX(scholarship_participants.program) as program,
                MAX(scholarship_participants.prev_chapter) as prev_chapter,
                MAX(scholarship_participants.created_at) as joined_at, 
                MAX(course_students.graduate) as graduate, 
                MAX(course_students.progress) as progress, 
                MAX(course_students.cert_claim_date) as cert_claim_date, 
                COUNT(CASE WHEN live_attendance.status = 1 THEN 1 END) as total_live_session,
                COUNT(CASE WHEN live_attendance.status = 1 AND live_attendance.created_at >= '2025-08-12' THEN 1 END) as valid_live_since_batch2,
                MIN(CASE WHEN live_attendance.status = 1 THEN live_attendance.created_at END) as graduated_at,
                MAX(scholarship_participants.is_reference_followup) as is_reference_followup,
                scholarship_participants.reference_comentor
            ")
            ->join('course_students', 'course_students.user_id = scholarship_participants.user_id', 'left')
            ->join('live_attendance', 'live_attendance.user_id = scholarship_participants.user_id', 'left')
            ->where('scholarship_participants.reference_comentor', $leader['referral_code_comentor'])
            ->where('scholarship_participants.deleted_at', null)
            ->groupBy('scholarship_participants.user_id')
            ->get();

        $members = $memberQuery->getResultArray();

        // Mapping occupation ke bahasa Indonesia
        $occupationMap = [
            'employee' => 'Karyawan / Profesional / PNS',
            'fresh_graduate' => 'Fresh Graduate',
            'jobseeker' => 'Job Seeker / Pencari Kerja',
            'college_student' => 'Mahasiswa',
            'freelance' => 'Freelance',
            'entrepreneur' => 'Wirausaha (UMKM)',
            'student' => 'Pelajar',
        ];

        foreach ($members as $key => $member) {
            // Fix untuk batch 1: graduated_at hanya valid jika ada live attendance sejak 2025-08-12
            // Cek program = RuangAI2025B1 ATAU prev_chapter = RuangAI2025B1 (yang daftar ulang)
            if (($member['prev_chapter'] === 'RuangAI2025B1') 
                && $member['valid_live_since_batch2'] == 0) {
                $members[$key]['graduated_at'] = null;
            }
            
            $members[$key]['status'] = $member['graduate'] == 1 ? 'lulus' : 'terdaftar';
            $members[$key]['progress'] = (int) $member['progress'];
            $members[$key]['total_live_session'] = (int) $member['total_live_session'];
            
            // Translate occupation to Indonesian
            $occupation = $member['occupation'] ?? '';
            $members[$key]['occupation'] = $occupationMap[$occupation] ?? $occupation;

            // Flagging berdasarkan is_reference_followup
            if ($member['is_reference_followup'] == 1) {
                // Peserta dari followup/mapping
                $members[$key]['from'] = 'mapping';
            } else {
                // Peserta dari register langsung
                $members[$key]['from'] = 'register';
            }
        }


        // Filter member graduated by status completed
        $graduated = count(array_filter($members, static fn($member) => $member['status'] === 'lulus'));
        $this->data['total_graduated'] = $graduated;
        $this->data['total_member'] = count($members);
        $this->data['members'] = $members;
        $this->data['leader'] = $leader;

        return $this->respond($this->data);
    }
}
