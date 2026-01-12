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
        helper('scholarship');
        
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $this->data['email']        = $jwt->user['email'];
        $this->data['name']         = $jwt->user['name'];
        $this->data['meeting_code'] = $meeting_code;

        $db = \Config\Database::connect();
        
        // Ambil data participant untuk pengecekan reference_comentor
        $participant = $db->table('scholarship_participants')
            ->select('reference_comentor, is_reference_followup, program, is_participating_other_ai_program')
            ->where('user_id', $jwt->user_id)
            ->get()
            ->getRow();

        // Get meeting detail with batch name
        $meeting = $db->table('live_meetings')
            ->select('live_meetings.id, live_meetings.title, live_meetings.meeting_date, live_meetings.meeting_time, live_meetings.live_batch_id, live_meetings.status, live_batch.name as batch_name')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('live_meetings.meeting_code', $meeting_code)
            ->where('live_meetings.zoom_meeting_id !=', null)
            ->get()
            ->getRowArray();
        
        if(! $meeting) {
            return $this->respond([
                'status'  => 'error',
                'message' => 'Meeting not found'
            ]);
        }

        // Check if user should access this meeting based on reference_comentor
        if ($participant && isset($participant->reference_comentor) && $participant->reference_comentor == 'co-sheli') {
            // Jika CO-Sheli, hanya bisa akses Batch Comentor Followup
            $this->data['is_followup'] = true;
        } else {
            // Jika bukan CO-Sheli, tidak bisa akses Batch Comentor Followup
            $this->data['is_followup'] = false;
        }

        // Get course detail
        $CourseModel = model('Course\Models\CourseModel');
        $course      = $CourseModel
                        ->select('courses.id, courses.slug')
                        ->join('live_batch', 'live_batch.course_id = courses.id')
                        ->where('live_batch.id', $meeting['live_batch_id'])
                        ->first();
        $this->data['course'] = $course;

        // Check if user has already completed the course
        $completedLessons = $db->table('course_lessons')
            ->select('count(course_lessons.id) as total_lessons, count(course_lesson_progress.user_id) as completed')
            ->join('course_lesson_progress', 'course_lesson_progress.lesson_id = course_lessons.id AND user_id = ' . $jwt->user_id, 'left')
            ->where('course_lessons.course_id', $course['id'])
            ->where('course_lessons.mandatory', 1)
            ->get()
            ->getRowArray();
        $this->data['total_lessons']    = $completedLessons['total_lessons'] ?? 1;
        $this->data['lesson_completed'] = $completedLessons['completed'] ?? 0;
        $this->data['completed']        = round($completedLessons['completed'] / $completedLessons['total_lessons'] * 100);
        
        // Get course_students
        $this->data['student'] = $db->table('course_students')
            ->select('course_students.progress, course_students.graduate, certificates.cert_claim_date, certificates.cert_code, course_students.expire_at')
            ->join('certificates', 'certificates.user_id = course_students.user_id AND certificates.entity_id = course_students.course_id', 'left')
            ->where('course_students.course_id', $course['id'])
            ->where('course_students.user_id', $jwt->user_id)
            ->get()
            ->getRowArray();

        // Check if user already registered and has a zoom join link
        $AttendanceModel = model('Course\Models\LiveAttendanceModel');
        $attendance      = $AttendanceModel->where('live_meeting_id', $meeting['id'])->where('user_id', $jwt->user_id)->first();
        
        $this->data['meeting'] = $meeting;
        $this->data['zoom_join_link'] = $attendance ? $attendance['zoom_join_link'] : null;

        $this->data['is_mentor'] = $jwt->user['role_id'] == 5 ? true : false;
        $this->data['is_comentor'] = $jwt->user['role_id'] == 4 ? true : false;
        $this->data['is_mentee_comentor'] = false;
        $this->data['is_reference_followup'] = $participant && $participant->is_reference_followup == 1 ? true : false;
        $this->data['is_participating_other_ai_program'] = $participant && $participant->is_participating_other_ai_program == 1 ? true : false;
        $this->data['comentor'] = null;
        $this->data['program'] = $participant ? $participant->program : null;
        
        if ($participant) {
            if (isset($participant->reference_comentor)) {
                $this->data['is_mentee_comentor'] = true;
                $comentorData = $db->table('scholarship_participants')
                    ->select('fullname')
                    ->where('scholarship_participants.referral_code_comentor', $participant->reference_comentor)
                    ->get()
                    ->getRow();
                $this->data['comentor'] = $comentorData ? $comentorData->fullname : null;
            }
        }
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
