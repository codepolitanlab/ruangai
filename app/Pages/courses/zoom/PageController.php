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
        $meeting      = $MeetingModel->select('id,title,meeting_date,meeting_time,live_batch_id')->where('meeting_code', $meeting_code)->first();
        
        if(! $meeting) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Meeting not found'
            ]);
        }
        
        // Get course detail
        $CourseModel = model('Course\Models\CourseModel');
        $course      = $CourseModel
                        ->select('courses.id, courses.slug')
                        ->join('live_batch', 'live_batch.course_id = courses.id')
                        ->where('live_batch.id', $meeting['live_batch_id'])
                        ->first();
        $this->data['course'] = $course;
        
        // Check if user already registered and has a zoom join link
        $AttendanceModel = model('Course\Models\LiveAttendanceModel');
        $attendance      = $AttendanceModel->where('live_meeting_id', $meeting['id'])->where('user_id', $jwt->user_id)->first();
        
        $this->data['meeting'] = $meeting;
        $this->data['zoom_join_link'] = $attendance ? $attendance['zoom_join_link'] : null;
        return $this->respond($this->data);
    }

    public function postRegister() 
    {
        $meeting_code = $this->request->getPost('meeting_code');
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();

        // Get zoom join link from live_attendance if already registered
        $LiveAttendanceModel = model('Course\Models\LiveAttendanceModel');
        $registered = $LiveAttendanceModel
                        ->select('zoom_join_link')
                        ->join('live_meetings', 'live_meetings.id = live_attendance.live_meeting_id')
                        ->where('user_id', $jwt->user_id)
                        ->where('meeting_code', $meeting_code)
                        ->first();
        if ($registered) {
            return redirect()->to($registered['zoom_join_link']);

        } else {
            // Get user by user_id
            $userModel = model('Heroicadmin\Modules\User\Models\UserModel');
            $user      = $userModel->where('id', $jwt->user_id)->first();

            // Get zoom_meeting_id from live_meeting table
            $liveMeetingModel = model('Course\Models\LiveMeetingModel');
            $liveMeeting      = $liveMeetingModel->select('live_meetings.id, zoom_meeting_id, zoom_link, course_id')
                                                ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
                                                ->where('meeting_code', $meeting_code)
                                                ->first();
            $zoom_meeting_id  = $liveMeeting['zoom_meeting_id'] ?? null;

            // Register user to Zoom Meeting
            if($zoom_meeting_id) {
                $Zoom = new \Course\Libraries\Zoom();
                try {
                    $joinLink = $Zoom->registerToMeeting($user['email'], $user['name'], $zoom_meeting_id);
                } catch (\Exception $e) {
                    return $this->respond([
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ]);
                }
                
                // Save join link to live_attendance table
                $data = [
                    'user_id'         => $jwt->user_id,
                    'live_meeting_id' => $liveMeeting['id'],
                    'course_id'       => $liveMeeting['course_id'],
                    'zoom_join_link'  => $joinLink
                ];
                $LiveAttendanceModel->insert($data);
            }

            // Fallback to zoom link
            else if($liveMeeting['zoom_link']) {
                $joinLink = $liveMeeting['zoom_link'];
            }

            // Show 404 exception
            else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Zoom meeting ID or Zoom link not set');
            }

            return $this->respond([
                'status' => 'success',
                'zoom_join_link' => $joinLink
            ]);
        }
    }

}
