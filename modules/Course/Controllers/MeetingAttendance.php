<?php

namespace Course\Controllers;

use CodeIgniter\API\ResponseTrait;
use Exception;
use Heroicadmin\Controllers\AdminController;

class MeetingAttendance extends AdminController
{
    use ResponseTrait;

    public $data = [
        'page_title' => 'Live Attendance',
        'module'     => 'elearning',
        'submodule'  => 'course',
    ];
    protected $model;
    protected $batchModel;

    public function __construct()
    {
        $this->model = model('Course\Models\LiveAttendanceModel');
    }

    public function index($meeting_id = null)
    {
        $data['page_title'] = 'Live Session Attendance';

        // Get meeting
        $data['meeting'] = model('Course\Models\LiveMeetingModel')
            ->select('live_batch.name as batch, live_batch.course_id, live_meetings.*')
            ->join('live_batch', 'live_batch.id = live_batch_id')
            ->where('live_meetings.id', $meeting_id)
            ->where('live_meetings.deleted_at', null)
            ->first();

        // Get all attendance stats
        $db = \Config\Database::connect();
        $data['stats'] = $db->query('SELECT
            COUNT(DISTINCT IF(duration > 1800, user_id, NULL)) AS users_durasi_gt_1800,
            COUNT(DISTINCT IF(meeting_feedback_id IS NOT NULL, user_id, NULL)) AS users_isi_feedback,
            COUNT(DISTINCT IF(duration > 1800 AND meeting_feedback_id IS NULL, user_id, NULL))  AS belum_isi_feedback,
            COUNT(DISTINCT IF(status = 1, user_id, NULL))  AS users_valid,
            COUNT(DISTINCT IF(status = 0, user_id, NULL))  AS users_tidak_valid
            FROM live_attendance
            WHERE live_meeting_id = ' . $meeting_id)->getRowArray();

        // Base query with joins and subqueries
        $this->model->select('live_attendance.id, users.name, users.email, users.phone, live_attendance.duration, zoom_join_link, meeting_feedback_id, live_attendance.status, course_students.graduate, live_meeting_feedback.content as feedback_content');
        $this->model->join('users', 'users.id = live_attendance.user_id');
        $this->model->join('course_students', 'course_students.user_id = live_attendance.user_id AND course_students.course_id = live_attendance.course_id', 'left');
        $this->model->join('live_meeting_feedback', 'live_meeting_feedback.user_id = live_attendance.user_id', 'left');
        $this->model->where('live_attendance.live_meeting_id', $meeting_id);

        // Apply filters
        $filter = $this->request->getGet('filter');

        if (! empty($filter)) {
            if (! empty($filter['name'])) {
                $this->model->like('users.name', $filter['name']);
            }
            if (! empty($filter['email'])) {
                $this->model->like('users.email', $filter['email']);
            }
            if (isset($filter['durasi'])) {
                if ($filter['durasi'] === '1') {
                    $this->model->where('live_attendance.duration >=', 1800);
                } else if ($filter['durasi'] === '0') {
                    $this->model->where('live_attendance.duration <', 1800);
                }
            }
            if (isset($filter['feedback'])) {
                if ($filter['feedback'] === '1') {
                    $this->model->where('live_attendance.meeting_feedback_id !=', null);
                } else if ($filter['feedback'] === '0') {
                    $this->model->where('live_attendance.meeting_feedback_id', null);
                }
            }
            if (isset($filter['status'])) {
                if ($filter['status'] === '1') {
                    $this->model->where('live_attendance.status', '1');
                } else if ($filter['status'] === '0') {
                    $this->model->where('live_attendance.status', '0');
                }
            }
            if (isset($filter['graduate'])) {
                if ($filter['graduate'] === '1') {
                    $this->model->where('course_students.graduate', '1');
                } else if ($filter['graduate'] === '0') {
                    $this->model->where('course_students.graduate', '0');
                }
            }
        } else {
            $this->model->orderBy('live_attendance.created_at', 'desc');
        }

        // Get perpage value from request, default to 10
        $perpage = (int) $this->request->getGet('perpage') ?: 10;

        // Paginate results
        $data['attenders'] = $this->model->asObject()->paginate($perpage);
        $data['pager']     = $this->model->pager;

        // Decode kolom feedback_content jika ada
        foreach ($data['attenders'] as &$row) {
            if (!empty($row->feedback_content)) {
                $row->feedback_content = json_decode($row->feedback_content);
            }
        }

        // Pass filter values and perpage to view
        $data['filter']       = $filter;
        $data['per_page']     = $perpage;
        $data['current_page'] = $this->request->getGet('page') ?? 1;
        $data['live_meeting'] = model('Course\Models\LiveMeetingModel')->where('id', $meeting_id)->first();

        $this->data = array_merge($this->data, $data);

        return pageView('Course\Views\live\meeting\attendance\index', $this->data);
    }

    public function form($live_meeting_id, $id = null)
    {
        $LiveMeetingModel = model('Course\Models\LiveMeetingModel');

        $data['meeting'] = $LiveMeetingModel
            ->select('live_batch.name as batch, live_meetings.*')
            ->join('live_batch', 'live_batch.id = live_batch_id')
            ->where('live_meetings.id', $live_meeting_id)
            ->where('live_meetings.deleted_at', null)
            ->first();

        if ($id) {
            // Mode Edit: Ambil data scholarship
            $liveAttendance     = model('Course\Models\LiveAttendanceModel');
            $data['attendance'] = $liveAttendance
                ->select('live_attendance.*, users.name, users.email, live_meeting_feedback.content as feedback_content')
                ->join('users', 'users.id = live_attendance.user_id')
                ->join('live_meeting_feedback', 'live_meeting_feedback.user_id = live_attendance.user_id', 'left')
                ->where('live_attendance.deleted_at', null)
                ->where('live_attendance.id', $id)
                ->asObject()
                ->first();

            // Pisahkan rate dan feedback dari JSON
            if (!empty($data['attendance']->feedback_content)) {
                $feedbackData = json_decode($data['attendance']->feedback_content);
                $data['attendance']->rate = $feedbackData->rate ?? null;
                $data['attendance']->feedback = $feedbackData->content ?? null;
                unset($data['attendance']->feedback_content); // opsional: hapus kolom JSON mentah
            }

            if (! $data['attendance']) {
                session()->setFlashdata('error_message', 'Data tidak ditemukan');

                return redirect()->to(urlScope() . '/course/live/meeting/' . $live_meeting_id . '/attendance');
            }

            $data['page_title'] = 'Edit Live Attendance Form';
        }

        $this->data = array_merge($this->data, $data);

        return view('Course\Views\live\meeting\attendance\form', $this->data);
    }

    public function save($live_meeting_id)
    {
        $id    = $this->request->getPost('id');
        $email = $this->request->getPost('email');

        // basic validation
        if (empty($email)) {
            session()->setFlashdata('error_message', 'Email wajib diisi');
            return redirect()->back()->withInput();
        }

        // Get user_id by email from users table
        $userModel = model('UserModel');
        $user      = $userModel->where('email', $email)->first();

        if (!$user) {
            session()->setFlashdata('error_message', 'Email tidak ditemukan');
            return redirect()->to(urlScope() . '/course/live/meeting/' . $live_meeting_id . '/attendant/add');
        }
        $user_id = $user['id'];

        // Get course_id by live_meeting_id
        $liveMeetingModel = model('Course\Models\LiveMeetingModel');
        $liveMeeting      = $liveMeetingModel
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('live_meetings.id', $live_meeting_id)
            ->first();

        if (!$liveMeeting) {
            session()->setFlashdata('error_message', 'Live meeting tidak ditemukan');
            return redirect()->back()->withInput();
        }

        $course_id = $liveMeeting['course_id'];

        // Ambil semua input yang diperlukan
        $duration = $this->request->getPost('duration');
        $status   = $this->request->getPost('status');

        // normalisasi status: kalau kosong -> null, else cast ke int (0/1)
        $status = $status === '' ? null : (int)$status;

        $data = [
            'user_id'         => $user_id,
            'course_id'       => $course_id,
            'live_meeting_id' => $live_meeting_id,
            'duration'        => $duration,
            'status'          => $status,
        ];

        $liveAttendanceModel = model('Course\Models\LiveAttendanceModel');
        $liveMeetingFeedbackModel = model('Course\Models\LiveMeetingFeedbackModel');

        try {
            if ($id) {
                // Update existing row
                $data['updated_at'] = date('Y-m-d H:i:s');
                $liveAttendanceModel->update($id, $data);

                // Update existing feedback row
                $content = (object) [
                    'rate'    => $this->request->getPost('rate'),
                    'content' => $this->request->getPost('feedback'),
                ];

                $feedback = [
                    'user_id'         => $user_id,
                    'live_meeting_id' => $live_meeting_id,
                    'content'         => json_encode($content),
                    'updated_at'      => date('Y-m-d H:i:s'),
                ];

                $meeting_feedback_id = (int) $this->request->getPost('meeting_feedback_id');
                $liveMeetingFeedbackModel->update($meeting_feedback_id, $feedback);

                // Check if duration >= 5400 , status = 1 and if content is not empty
                $courseStudentModel = model('Course\Models\CourseStudentModel');
                if ($duration >= 5400 && $status == 1 && !empty($content->content)) {
                    $courseStudentModel->markAsGraduate($user_id, $course_id);
                } else {
                    $courseStudentModel->markAsNotGraduate($user_id, $course_id);
                }
                session()->setFlashdata('success_message', 'Data berhasil diperbarui');
            } else {
                // Check if row with same user_id and live_meeting_id already exists (not deleted)
                $existing = $liveAttendanceModel
                    ->where('user_id', $user_id)
                    ->where('live_meeting_id', $live_meeting_id)
                    ->where('deleted_at', null)
                    ->first();

                if ($existing) {
                    session()->setFlashdata('error_message', 'Data sudah ada');
                    return redirect()->to(urlScope() . '/course/live/meeting/' . $live_meeting_id . '/attendant/add');
                }

                // Insert feedback
                $content = (object) [
                    'rate'    => $this->request->getPost('rate'),
                    'content' => $this->request->getPost('feedback'),
                ];

                $feedback = [
                    'user_id'         => $user_id,
                    'live_meeting_id' => $live_meeting_id,
                    'content'         => json_encode($content),
                    'created_at'      => date('Y-m-d H:i:s'),
                ];

                $live_meeting_feedback_id = $liveMeetingFeedbackModel->insert($feedback);

                // Insert
                $data['meeting_feedback_id'] = $live_meeting_feedback_id;
                $data['created_at'] = date('Y-m-d H:i:s');
                $liveAttendanceModel->insert($data);

                // Check if duration >= 5400 , status = 1 and if content is not empty
                if ($duration >= 5400 && $status == 1 && !empty($content->content)) {
                    $courseStudentModel = model('Course\Models\CourseStudentModel');
                    $courseStudentModel->markAsGraduate($user_id, $course_id);
                }

                session()->setFlashdata('success_message', 'Data berhasil ditambahkan');
            }

            // Generate token reward if not exist
            $userTokenModel = model('UserToken');
            $isExist = $userTokenModel->isExists($user_id, 'graduate');

            if (!$isExist) {
                $userTokenModel->generateToken($user_id, 'graduate');
            }

            return redirect()->to(urlScope() . '/course/live/meeting/' . $live_meeting_id . '/attendant');
        } catch (\Exception $e) {
            session()->setFlashdata('error_message', 'Gagal menyimpan data: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function delete($live_meeting_id, $id)
    {
        $liveAttendanceModel = model('Course\Models\LiveAttendanceModel');

        try {
            // Soft delete: set deleted_at
            $liveAttendanceModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
            session()->setFlashdata('success_message', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            session()->setFlashdata('error_message', 'Gagal menghapus data: ' . $e->getMessage());
        }

        return redirect()->to(urlScope() . '/course/live/meeting/' . $live_meeting_id . '/attendant');
    }

    /**
     * Sync attendance from Zoom participant API,
     * then update attendance table, by checking if user exists and fulfil minimum duration (by flag status: 0|1),
     * then check if user has submit feedback by inputting meeting_feedback_id
     *
     * @param mixed $live_meeting_id
     */
    public function sync($live_meeting_id)
    {
        $this->data['live_meeting_id'] = $live_meeting_id;

        return view('Course\Views\live\meeting\attendance\sync', $this->data);
    }

    public function startSync($live_meeting_id)
    {
        $liveAttendancModel = model('Course\Models\LiveAttendanceModel');
        $courseStudentModel = model('Course\Models\CourseStudentModel');

        // Get zoom_meeting_id from live_meeting table
        $meeting = model('Course\Models\LiveMeetingModel')->select('zoom_meeting_id, course_id')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('live_meetings.id', $live_meeting_id)
            ->first();
        $zoom_meeting_id = $meeting['zoom_meeting_id'];
        $course_id       = $meeting['course_id'];

        $Zoom = new \Course\Libraries\Zoom();

        // Get participant list from cache file or Zoom participant API
        $cachePath = WRITEPATH . 'cache/zoom_participants_' . $live_meeting_id . '.json';
        if (file_exists($cachePath)) {
            $cache     = file_get_contents($cachePath);
            $participants = json_decode($cache, true);
        } else {
            // Get participant list from Zoom participant API
            $Zoom->getParticipantList($zoom_meeting_id);
            $participants = $Zoom->participants;

            // Save participants to cache file
            if (!empty($participants)) {
                file_put_contents($cachePath, json_encode($participants));
            }
        }

        $participants = $Zoom->accumulateDurations($participants);
        if (! $participants) {
            return $this->respond([
                'status'  => 'success',
                'message' => 'Tidak ada data partisipan',
            ]);
        }

        // Update attendance table
        // while iterating, check if user minimum duration is pass and user has submit feedback
        $participantEmails = array_keys($participants);
        $users             = model('Heroicadmin\Modules\User\Models\UserModel')->select('id, email')->whereIn('email', $participantEmails)->findAll();
        if (! $users) {
            return $this->respond([
                'status'  => 'success',
                'message' => 'Tidak ada partisipan di daftar user',
            ]);
        }

        $inserted = 0;
        $updated  = 0;

        $db = \Config\Database::connect();
        foreach ($users as $user) {
            // Check if user has submit feedback
            $feedback = $db->table('live_meeting_feedback')->where('user_id', $user['id'])
                ->where('live_meeting_id', $live_meeting_id)
                ->get()
                ->getRowArray();

            $validParticipant['user_id']             = $user['id'];
            $validParticipant['course_id']           = $course_id;
            $validParticipant['live_meeting_id']     = $live_meeting_id;
            $validParticipant['duration']            = $participants[$user['email']] ?? 0;
            $validParticipant['meeting_feedback_id'] = $feedback['id'] ?? null;
            $validParticipant['status']              = ($validParticipant['duration'] >= 1800) && null !== $validParticipant['meeting_feedback_id'] ? '1' : '0';

            // Check if user is already in attendance table
            $exist = $liveAttendancModel->where('user_id', $user['id'])
                ->where('live_meeting_id', $live_meeting_id)
                ->first();
            if ($exist) {
                $liveAttendancModel->where('id', $exist['id'])->set($validParticipant)->update();
                $updated++;

                continue;
            }

            $liveAttendancModel->insert($validParticipant);
            $inserted++;

            // Check if user eligible to graduate and set graduate to 1
            $student = $courseStudentModel->getStudent($user['id'], $course_id);

            $hasValidDuration   = $validParticipant['duration'] >= 1800;
            $hasFeedback        = !is_null($validParticipant['meeting_feedback_id']);
            $notGraduated       = $student['graduate'] == 0;
            $progressCompleted  = (int) $student['progress'] == 100;

            $isEligibleToGraduate = $hasValidDuration && $hasFeedback && $notGraduated && $progressCompleted;

            if ($isEligibleToGraduate) {
                $courseStudentModel->markAsGraduate($user['id'], $course_id);
            }
        }

        // TODO: Return sync result
        return $this->respond([
            'status'             => 'success',
            'total_participants' => count($participants ?? []),
            'total_users'        => count($users ?? []),
            'inserted'           => $inserted,
            'updated'            => $updated,
        ]);
    }

    public function exports($meeting_id = null)
    {
        // Get meeting
        $meeting = model('Course\Models\LiveMeetingModel')
            ->select('live_batch.name as batch, live_batch.course_id, live_meetings.*')
            ->join('live_batch', 'live_batch.id = live_batch_id')
            ->where('live_meetings.id', $meeting_id)
            ->where('live_meetings.deleted_at', null)
            ->first();

        $liveAttendanceModel = new \App\Models\LiveAttendance();

        //Get all data live attendance by meeting id
        $liveAttendanceModel->select('users.name, users.phone, users.email, live_attendance.duration, IF(live_attendance.duration > 1800, 1, NULL) AS duration_valid, live_attendance.meeting_feedback_id, live_attendance.status as attendance_valid, course_students.graduate, live_attendance.created_at');
        $liveAttendanceModel->join('users', 'users.id = live_attendance.user_id');
        $liveAttendanceModel->join('course_students', 'course_students.user_id = users.id  AND live_attendance.course_id = course_students.course_id');
        $liveAttendanceModel->join('live_meetings', 'live_meetings.id = live_attendance.live_meeting_id');
        $liveAttendanceModel->where('live_meetings.id', $meeting_id);
        $liveAttendanceModel->groupBy('live_attendance.id, users.name, users.phone, users.email, live_attendance.duration, course_students.graduate, live_attendance.status, live_attendance.created_at, live_attendance.meeting_feedback_id');
        $participants = $liveAttendanceModel->findAll();

        // Name file export
        $filename = "Live Session Attendance - " . $meeting['batch'] . " - " . $meeting['subtitle'] . ".csv";

        // Header untuk download
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; charset=utf-8");

        $file = fopen('php://output', 'w');

        if (!empty($participants)) {
            // Tulis header (nama kolom otomatis dari array keys)
            fputcsv($file, array_keys($participants[0]));

            // Tulis data
            foreach ($participants as $row) {
                fputcsv($file, $row);
            }
        }

        fclose($file);
        exit;
    }
}
