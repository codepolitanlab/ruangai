<?php

namespace Course\Controllers;

use App\Pages\BaseController;

class Zoom extends BaseController
{
    public function index($meeting_code)
    {
        $user_id = session()->get('user_id');

        // If user not login from backend, redirect to frontend zoom link processor
        if(! $user_id) {
            return redirect()->to('courses/zoom/' . $meeting_code);
        }

        // Get zoom join link from live_attendance if already registered
        $LiveAttendanceModel = model('Course\Models\LiveAttendanceModel');
        $registered = $LiveAttendanceModel
                        ->select('zoom_join_link')
                        ->join('live_meetings', 'live_meetings.id = live_attendance.live_meeting_id')
                        ->where('user_id', session()->get('user_id'))
                        ->where('meeting_code', $meeting_code)
                        ->first();
        if ($registered) {
            return redirect()->to($registered['zoom_join_link']);

        } else {
            // Get user by user_id
            $userModel = model('Heroicadmin\Modules\User\Models\UserModel');
            $user      = $userModel->where('id', session()->get('user_id'))->first();

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
                $joinLink = $Zoom->registerToMeeting($user['email'], $user['name'], $zoom_meeting_id);
                
                // Save join link to live_attendance table
                $data = [
                    'user_id'         => session()->get('user_id'),
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

            return redirect()->to($joinLink);
        }
    }
}