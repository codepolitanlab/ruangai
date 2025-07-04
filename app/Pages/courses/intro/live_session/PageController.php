<?php namespace App\Pages\courses\intro\live_session;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title'  => "Live Session",
        'module'      => 'course_live',
        'active_page' => 'live',
    ];

    public function getData($course_id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken();

        $db = \Config\Database::connect();
        $this->data['course'] = $db->table('courses')
                                    ->select('courses.*, courses.id, live_batch.*, live_batch.id as batch_id')
                                    ->join('live_batch', 'live_batch.id = courses.current_batch_id', 'left')
                                    ->where('courses.id', $course_id)
                                    ->get()
                                    ->getRowArray();

        $attended = $db->table('live_attendance')
                        ->select('live_meeting_id, live_meetings.title, live_meetings.subtitle, live_meetings.theme_code, live_meetings.meeting_date, live_meetings.meeting_time, live_batch.name as batch_title')
                        ->join('live_meetings', 'live_meetings.id = live_attendance.live_meeting_id')
                        ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
                        ->where('live_attendance.course_id', $course_id)
                        ->where('user_id', $jwt->user_id)
                        ->get()
                        ->getResultArray();
        if($attended) {
            $attendedCode = array_column($attended, 'theme_code');
        }

        $live_sessions = $db->table('live_meetings')
                            ->where('live_batch_id', $this->data['course']['current_batch_id'])
                            ->where('deleted_at', null)
                            ->orderBy('meeting_date', 'ASC')
                            ->orderBy('meeting_time', 'ASC')
                            ->get()
                            ->getResultArray();

        $this->data['live_sessions'] = [];
        if($live_sessions)
        {
            foreach($live_sessions as $key => $live_session) {
                $this->data['live_sessions'][$key] = $live_session;

                // Cek jika tanggal sudah lewat
                if(date('Y-m-d') == $live_session['meeting_date']) {
                    // Cek jika waktu sudah lewat 2 jam
                    if(date('H:i:s') > date('H:i:s', strtotime('+2 hours', strtotime($live_session['meeting_time'])))) {
                        if(in_array($live_session['id'], $attended))
                            $this->data['live_sessions'][$key]['status_date'] = 'attended';
                        else
                            $this->data['live_sessions'][$key]['status_date'] = 'completed';
                    } else if(date('H:i:s') < $live_session['meeting_time']) {
                        $this->data['live_sessions'][$key]['status_date'] = 'upcoming';
                    } else {
                        $this->data['live_sessions'][$key]['status_date'] = 'ongoing';
                    }
                } else if(date('Y-m-d') > $live_session['meeting_date']) {
                    if(in_array($live_session['id'], $attended))
                        $this->data['live_sessions'][$key]['status_date'] = 'attended';
                    else
                        $this->data['live_sessions'][$key]['status_date'] = 'completed';
                } else {
                    $this->data['live_sessions'][$key]['status_date'] = 'upcoming';
                }
            }
        }

        $this->data['enable_live_recording'] = service('settings')->get('Course.enableLiveRecording');

        $this->data['attended'] = $attended;
        $this->data['attendedCode'] = $attendedCode ?? [];

        // Get course_students
        $this->data['student'] = $db->table('course_students')
                                    ->select('progress, cert_claim_date, cert_code, expire_at')
                                    ->where('course_id', $course_id)
                                    ->where('user_id', $jwt->user_id)
                                    ->get()
                                    ->getRowArray();
        $this->data['is_expire'] = $this->data['student']['expire_at'] && $this->data['student']['expire_at'] < date('Y-m-d H:i:s') ? true : false;

        return $this->respond($this->data);
    }
}
