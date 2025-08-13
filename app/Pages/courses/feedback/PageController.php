<?php

namespace App\Pages\courses\feedback;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Live Session Feedback',
        'module'      => 'learn',
        'active_page' => 'feedback',
    ];

    public function getData($meeting_code)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        $db = \Config\Database::connect();

        // Get meeting detail
        $MeetingModel = model('Course\Models\LiveMeetingModel');
        $meeting      = $MeetingModel
            ->select('live_meetings.id, title, subtitle, meeting_date, meeting_time, live_batch_id, live_meetings.status, course_id')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('meeting_code', $meeting_code)
            ->where('zoom_meeting_id !=', null)
            ->first();
        
        if(! $meeting) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Meeting not found'
            ]);
        }

        // Get course
        if (! $course = cache('course_' . $meeting['course_id'])) {
            $course = $db->table('courses')
                ->select('id, course_title, slug')
                ->where('id', $meeting['course_id'])
                ->get()
                ->getRowArray();

            // Save into the cache for 5 minutes
            cache()->save('course_' . $meeting['course_id'], $course, 3600);
        }
        $this->data['course'] = $course;

        // Get user data
        $this->data['user'] = $db->table('users')
            ->select('id, name')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        $this->data['meeting'] = $meeting;

        return $this->respond($this->data);
    }
}
