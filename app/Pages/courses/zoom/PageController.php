<?php namespace App\Pages\courses\zoom;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Courses Zoom Page",
        'module' => 'courses'
    ];

    public function getData($meeting_code)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $this->data['email']        = $jwt->user['email'];
        $this->data['name']         = $jwt->user['name'];
        $this->data['meeting_code'] = $meeting_code;

        // Get meeting detail
        $MeetingModel = model('Course\Models\LiveMeetingModel');
        $meeting      = $MeetingModel->select('id,title,meeting_date,meeting_time')->where('meeting_code', $meeting_code)->first();
        
        // Check if user already registered and has a zoom join link
        $AttendanceModel = model('Course\Models\LiveAttendanceModel');
        $attendance      = $AttendanceModel->where('live_meeting_id', $meeting['id'])->where('user_id', $jwt->user_id)->first();
        
        $this->data['meeting'] = $meeting;
        $this->data['zoom_join_link'] = $attendance ? $attendance['zoom_join_link'] : null;
        return $this->respond($this->data);
    }
}
