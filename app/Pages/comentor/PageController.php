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
                scholarship_participants.fullname,
                scholarship_participants.whatsapp,
                scholarship_participants.email,
                scholarship_participants.created_at as joined_at, 
                course_students.graduate, 
                course_students.progress, 
                COUNT(CASE WHEN live_attendance.status = 1 THEN 1 END) as total_live_session
            ")
            ->join('course_students', 'course_students.user_id = scholarship_participants.user_id')
            ->join('live_attendance', 'live_attendance.user_id = scholarship_participants.user_id')
            ->where('scholarship_participants.reference', $leader['referral_code_comentor'])
            ->where('scholarship_participants.deleted_at', null)
            ->groupBy([
                'scholarship_participants.user_id'
            ])
            ->get();

        $members = $memberQuery->getResultArray();

        foreach ($members as $key => $member) {
            $members[$key]['status'] = $member['graduate'] == 1 ? 'lulus' : 'terdaftar';
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
