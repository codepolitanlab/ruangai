<?php

namespace App\Pages\courses\intro\live_session;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Live Session',
        'module'      => 'courses',
        'active_page' => 'live',
    ];

    public function getData($course_id)
    {
        helper('scholarship');
        
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $db                   = \Config\Database::connect();
        $this->data['course'] = $db->table('courses')
            ->where('courses.id', $course_id)
            ->get()
            ->getRowArray();

        if ($course_id == 1) {
            $this->data['module'] = 'misi_beasiswa';
        }

        // Get attended events
        $attended = $db->table('live_attendance')
            ->select('live_meeting_id, live_meetings.meeting_code, live_meetings.title, 
            live_meetings.subtitle, live_meetings.theme_code, duration, meeting_feedback_id, 
            meeting_date, meeting_time, live_batch.name as batch_title, 
            live_attendance.status, ADDTIME(meeting_time, SEC_TO_TIME(meeting_duration * 60)) AS meeting_end')
            ->join('live_meetings', 'live_meetings.id = live_attendance.live_meeting_id')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('live_attendance.course_id', $course_id)
            ->where('user_id', $jwt->user_id)
            ->orderBy('live_meetings.meeting_date', 'asc')
            ->get()
            ->getResultArray();
        if ($attended) {
            $attendedCode = [];
            foreach ($attended as $key => $value) {
                if ($value['status'] === '1')
                    $attendedCode[] = $value['theme_code'];
            }
        }

        $live_sessions = $db->table('live_meetings')
            ->select('live_meetings.*')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('live_batch.status', 'ongoing')
            ->where('live_batch.course_id', $course_id)
            ->where('live_meetings.deleted_at', null)
            ->orderBy('meeting_date', 'ASC')
            ->orderBy('meeting_time', 'ASC')
            ->get()
            ->getResultArray();

        $this->data['live_sessions'] = [];

        if ($live_sessions) {
            $readyLiveSessions = [];
            foreach ($live_sessions as $key => $live_session) {
                $readyLiveSessions[$key] = $live_session;

                $feedbackExists = $db->table('live_meeting_feedback')
                    ->where('user_id', $jwt->user_id)
                    ->where('live_meeting_id', $live_session['id'])
                    ->countAllResults() > 0;

                $readyLiveSessions[$key]['feedback_submitted'] = $feedbackExists;

                // Cek jika tanggal sudah lewat
                if (date('Y-m-d') === $live_session['meeting_date']) {
                    // Cek jika waktu sudah lewat 2 jam
                    if (date('H:i:s') > date('H:i:s', strtotime('+2 hours', strtotime($live_session['meeting_time'])))) {
                        if (in_array($live_session['id'], $attended, true)) {
                            $readyLiveSessions[$key]['status_date'] = 'attended';
                        } else {
                            $readyLiveSessions[$key]['status_date'] = 'completed';
                        }
                    } elseif (date('H:i:s') < $live_session['meeting_time']) {
                        $readyLiveSessions[$key]['status_date'] = 'upcoming';
                    } else {
                        $readyLiveSessions[$key]['status_date'] = 'ongoing';
                    }
                } elseif (date('Y-m-d') > $live_session['meeting_date']) {
                    if (in_array($live_session['id'], $attended, true)) {
                        $readyLiveSessions[$key]['status_date'] = 'attended';
                    } else {
                        $readyLiveSessions[$key]['status_date'] = 'completed';
                    }
                } else {
                    $readyLiveSessions[$key]['status_date'] = 'upcoming';
                }

                // Pack live meeting by status
                $this->data['live_sessions'][$live_session['status']][] = $readyLiveSessions[$key];
            }
        }

        $this->data['enable_live_recording'] = service('settings')->get('Course.enableLiveRecording');

        $this->data['attended']     = $attended;
        $this->data['attendedCode'] = $attendedCode ?? [];

        // Get course_students
        $this->data['student'] = $db->table('course_students')
            ->select('course_students.progress, course_students.graduate, certificates.cert_claim_date, certificates.cert_code, course_students.expire_at')
            ->join('certificates', 'certificates.user_id = course_students.user_id AND certificates.entity_id = course_students.course_id', 'left')
            ->where('course_students.course_id', $course_id)
            ->where('course_students.user_id', $jwt->user_id)
            ->get()
            ->getRowArray();
        $this->data['is_expire'] = $this->data['student']['expire_at'] && $this->data['student']['expire_at'] < date('Y-m-d H:i:s') ? true : false;

        // Check if user has already completed the course
        $completedLessons = $db->table('course_lessons')
            ->select('count(course_lessons.id) as total_lessons, count(course_lesson_progress.user_id) as completed')
            ->join('course_lesson_progress', 'course_lesson_progress.lesson_id = course_lessons.id AND user_id = ' . $jwt->user_id, 'left')
            ->where('course_lessons.course_id', $course_id)
            ->get()
            ->getRowArray();
        $this->data['total_lessons']    = $completedLessons['total_lessons'] ?? 1;
        $this->data['lesson_completed'] = $completedLessons['completed'] ?? 0;
        $this->data['completed']        = round($completedLessons['completed'] / $completedLessons['total_lessons'] * 100);

        $this->data['user'] = $db->table('users')
            ->select('id, name')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        // Ambil data participant berdasarkan user_id dengan null safety
        $participant = $db->table('scholarship_participants')
            ->select('reference, program, is_participating_other_ai_program')
            ->where('user_id', $jwt->user_id)
            ->get()
            ->getRow();

        $this->data['is_mentor'] = $jwt->user['role_id'] == 5 ? true : false;
        $this->data['is_comentor'] = $jwt->user['role_id'] == 4 ? true : false;
        $this->data['is_mentee_comentor'] = false;
        $this->data['is_participating_other_ai_program'] = $participant && $participant->is_participating_other_ai_program == 1 ? true : false;
        $this->data['comentor'] = null;
        $this->data['program'] = $participant ? $participant->program : null;
        
        if ($participant) {
            // Cek apakah reference mengandung "CO-" atau "co-"
            if (isset($participant->reference) && preg_match('/co\-/i', $participant->reference)) {
                $this->data['is_mentee_comentor'] = true;
                $comentorData = $db->table('scholarship_participants')
                    ->select('fullname')
                    ->where('scholarship_participants.referral_code_comentor', $participant->reference)
                    ->get()
                    ->getRow();
                $this->data['comentor'] = $comentorData ? $comentorData->fullname : null;
            }
        }

        // Jika tidak mengandung "CO-" atau "co-", lanjutkan proses
        return $this->respond($this->data);
    }

    public function postCheckAttendedStatus()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();
        $meeting_id = $this->request->getPost('meeting_id');

        // Get meeting_feedback_id by user_id and live_meeting_id
        $db = \Config\Database::connect();
        $meeting_feedback_id = $db->table('live_meeting_feedback')
            ->select('id')
            ->where('user_id', $jwt->user_id)
            ->where('live_meeting_id', $meeting_id)
            ->get()
            ->getRowArray()['id'] ?? null;

        if ($meeting_feedback_id) {
            // Update live_attendance
            $db->table('live_attendance')
                ->where('user_id', $jwt->user_id)
                ->where('live_meeting_id', $meeting_id)
                ->update([
                    'meeting_feedback_id' => $meeting_feedback_id,
                    'status' => 1
                ]);

            return $this->respond([
                'status' => 'success'
            ]);
        }

        return $this->respond([
            'status' => 'failed'
        ]);
    }
}
