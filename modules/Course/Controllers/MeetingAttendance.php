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

        // Base query with joins and subqueries
        $this->model->select('live_attendance.id, users.name, users.email, live_attendance.duration, zoom_join_link, duration, meeting_feedback_id, live_attendance.status');
        $this->model->join('users', 'users.id = live_attendance.user_id');
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
            if (! empty($filter['duration'])) {
                $this->model->like('live_attendance.duration', $filter['duration']);
            }
        } else {
            $this->model->orderBy('live_attendance.created_at', 'desc');
        }

        // Get perpage value from request, default to 10
        $perpage = (int) $this->request->getGet('perpage') ?: 10;

        // Paginate results
        $data['attenders'] = $this->model->asObject()->paginate($perpage);
        $data['pager']     = $this->model->pager;

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
                ->select('live_attendance.*, users.name, users.email')
                ->join('users', 'users.id = live_attendance.user_id')
                ->where('live_attendance.deleted_at', null)
                ->where('live_attendance.id', $id)
                ->asObject()
                ->first();

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

        // Get user_id by email from users table
        $userModel = model('Heroicadmin\Modules\Users\Models\UserModel');
        $user      = $userModel->where('email', $email)->first();
        if ($user) {
            $user_id = $user['id'];
        } else {
            session()->setFlashdata('error_message', 'Email tidak ditemukan');

            return redirect()->to(urlScope() . '/course/live/meeting/' . $live_meeting_id . '/attendant/add');
        }

        // Get course_id by live_meeting_id
        $liveMeetingModel = model('Course\Models\LiveMeetingModel');
        $liveMeeting      = $liveMeetingModel
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('live_meetings.id', $live_meeting_id)
            ->first();
        $course_id = $liveMeeting['course_id'];

        $data = [
            'user_id'         => $user_id,
            'course_id'       => $course_id,
            'live_meeting_id' => $live_meeting_id,
            'duration'        => $this->request->getPost('duration'),
        ];

        $liveAttendanceModel = model('Course\Models\LiveAttendanceModel');

        try {
            if ($id) {
                // Update data
                $data['updated_at'] = date('Y-m-d H:i:s');
                $liveAttendanceModel->update($id, $data);
            } else {
                // Check if row with same user_id and live_meeting_id already exists
                $existing = $this->model->where('user_id', $user_id)->where('live_meeting_id', $live_meeting_id)->first();
                if ($existing) {
                    session()->setFlashdata('error_message', 'Data sudah ada');

                    return redirect()->to(urlScope() . '/course/live/meeting/' . $live_meeting_id . '/attendant/add');
                }
                // Insert data baru
                $data['created_at'] = date('Y-m-d H:i:s');
                $liveAttendanceModel->insert($data);
            }

            session()->setFlashdata('success_message', 'Data berhasil disimpan');

            return redirect()->to(urlScope() . '/course/live/meeting/' . $data['live_meeting_id'] . '/attendant');
        } catch (Exception $e) {
            session()->setFlashdata('error_message', 'Gagal menyimpan data: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function delete($live_meeting_id, $id)
    {
        $liveAttendanceModel = model('Course\Models\LiveAttendanceModel');

        try {
            $liveAttendanceModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
            session()->setFlashdata('success_message', 'Data berhasil dihapus');
        } catch (Exception $e) {
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

        // Get zoom_meeting_id from live_meeting table
        $meeting = model('Course\Models\LiveMeetingModel')->select('zoom_meeting_id, course_id')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('live_meetings.id', $live_meeting_id)
            ->first();
        $zoom_meeting_id = $meeting['zoom_meeting_id'];
        $course_id       = $meeting['course_id'];

        $Zoom = new \Course\Libraries\Zoom();

        // Get participant list from cache file or Zoom participant API
        $cache        = \Config\Services::cache();
        $participants = $cache->get('zoom_participants_' . $live_meeting_id);
        if ($participants === null) {
            // Get participant list from Zoom participant API
            $Zoom->getAccessToken();
            $Zoom->getParticipantList($zoom_meeting_id);
            $participants = $Zoom->participants;

            // Save participants to cache file
            $cache->save('zoom_participants_' . $live_meeting_id, $participants);
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

        foreach ($users as $user) {
            // TODO: Check if user has submit feedback
            // $feedback = model('Course\Models\MeetingFeedbackModel')->where('user_id', $user['id'])
            //                                         ->where('live_meeting_id', $live_meeting_id)
            //                                         ->first();
            $validParticipant['user_id']             = $user['id'];
            $validParticipant['course_id']           = $course_id;
            $validParticipant['live_meeting_id']     = $live_meeting_id;
            $validParticipant['duration']            = $participants[$user['email']];
            $validParticipant['meeting_feedback_id'] = $feedback['id'] ?? null;
            $validParticipant['status']              = ($validParticipant['duration'] >= 600) && null !== $validParticipant['meeting_feedback_id'] ? '1' : '0';

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
}
