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
                        ->select('live_meeting_id')
                        ->where('course_id', $course_id)
                        ->where('user_id', $jwt->user_id)
                        ->get()
                        ->getResultArray();
        if($attended) {
            $attended = array_column($attended, 'live_meeting_id');
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

        $this->data['attended'] = $attended;

        return $this->respond($this->data);
    }
}
