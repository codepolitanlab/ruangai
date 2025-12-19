<?php

namespace App\Pages\scholarship;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Scholarship',
        'module'      => 'scholarship',
        'active_page' => 'scholarship',
    ];

    public function getData()
    {
        helper('scholarship');
        
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);
        $this->data['name'] = $jwt->user['name'];
        $db = \Config\Database::connect();
        
        // Get user's scholarships from scholarship_participants
        $this->data['scholarships'] = $db->table('scholarship_participants')
            ->select('scholarship_participants.*, events.event_name, events.date_start, events.date_end')
            ->join('events', 'events.code = scholarship_participants.program', 'left')
            ->where('scholarship_participants.user_id', $jwt->user_id)
            ->where('scholarship_participants.deleted_at', null)
            ->get()
            ->getResultArray();
        
        // Check if user is scholarship participant
        if (! function_exists('is_scholarship_participant')) helper('scholarship');
        $this->data['is_scholarship_participant'] = \is_scholarship_participant($jwt->user_id);
        $this->data['scholarship_url'] = scholarship_registration_url();

        return $this->respond($this->data);
    }
}
