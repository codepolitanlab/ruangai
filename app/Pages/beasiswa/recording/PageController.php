<?php

namespace App\Pages\beasiswa\recording;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Rekaman Live Session',
        'module'      => 'courses',
        'active_page' => 'live',
    ];

    public function getData($meeting_id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $db = \Config\Database::connect();

        // Get meeting data
        $meeting = $db->table('live_meetings')
            ->select('live_meetings.*, live_batch.name as batch_name, live_batch.course_id, courses.bunny_collection_id')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->join('courses', 'courses.id = live_batch.course_id')
            ->where('live_meetings.id', $meeting_id)
            ->where('live_meetings.deleted_at', null)
            ->get()
            ->getRowArray();

        if (!$meeting) {
            return $this->failNotFound('Rekaman tidak ditemukan');
        }

        // Check if user attended this meeting with valid status
        $attendance = $db->table('live_attendance')
            ->where('user_id', $jwt->user_id)
            ->where('live_meeting_id', $meeting_id)
            ->where('status', 1)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        // Allow access for admin and mentor
        $isAdmin = in_array($jwt->user['role_id'], [1, 3]);
        
        if (!$attendance && !$isAdmin) {
            return $this->respond([
                'response_code' => 403,
                'response_message' => 'Anda tidak memiliki akses untuk melihat rekaman ini',
            ]);
        }

        if (!$meeting['recording_link']) {
            return $this->respond([
                'response_code' => 404,
                'response_message' => 'Rekaman belum tersedia',
            ]);
        }

        $this->data['meeting'] = $meeting;
        $this->data['enable_live_recording'] = service('settings')->get('Course.enableLiveRecording');

        return $this->respond($this->data);
    }
}
