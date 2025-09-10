<?php

namespace App\Pages\zpanel\course\live\schedule\attendance;

use App\Models\LiveAttendance;
use App\Pages\zpanel\AdminController;
use Exception;

class PageController extends AdminController
{
    public $data = [
        'page_title' => 'Live Meeting Schedule',
    ];
    protected $model;
    protected $batchModel;

    public function __construct()
    {
        $this->model = new LiveAttendance();
    }

    public function getIndex($meeting_id = null)
    {
        $data['page_title'] = 'Live Session Attendance';

        // Base query with joins and subqueries
        $this->model->select('live_attendance.id, users.name, users.email, live_attendance.duration');
        $this->model->join('users', 'users.id = live_attendance.user_id');
        $this->model->where('live_attendance.live_meeting_id', $meeting_id);
        $this->model->where('live_attendance.deleted_at', null);

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
        $data['live_session'] = model('LiveMeetingModel')->where('id', $meeting_id)->first();

        // Count total records
        $data['total_records'] = $this->model->where('live_meeting_id', $meeting_id)->countAllResults();

        return pageView('zpanel/course/live/schedule/attendance/index', $data);
    }

    public function postIndex()
    {
        $id = $this->request->getPost('id');

        $data = [
            'user_id'         => $this->request->getPost('title'),
            'course_id'       => 1,
            'live_meeting_id' => $this->request->getPost('title'),
            'duration'        => $this->request->getPost('duration'),
        ];

        $eventsModel = new \App\Models\Events();

        try {
            if ($id) {
                // Update data
                $data['updated_at'] = date('Y-m-d H:i:s');
                $eventsModel->update($id, $data);
            } else {
                // Insert data baru
                $data['created_at'] = date('Y-m-d H:i:s');
                $eventsModel->insert($data);
            }

            session()->setFlashdata('success', 'Data berhasil disimpan');

            return redirect()->to('/zpanel/course/live/schedule/attendance');
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function postDelete()
    {
        $id          = $this->request->getPost('id');
        $eventsModel = new \App\Models\Events();

        try {
            $eventsModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menghapus data: ' . $e->getMessage());
        }

        return redirect()->to('/zpanel/events');
    }

    public function getExport($meeting_id = null)
    {
        $liveAttendanceModel = new \App\Models\LiveAttendance();

        //Get all data live attendance by meeting id
        $liveAttendanceModel->select('live_meetings.meeting_code, live_meetings.title, users.name, users.phone, users.email, live_attendance.duration, course_students.graduate, live_attendance.status, live_attendance.created_at');
        $liveAttendanceModel->join('users', 'users.id = live_attendance.user_id');
        $liveAttendanceModel->join('course_students', 'course_students.user_id = users.id');
        $liveAttendanceModel->join('live_meetings', 'live_meetings.id = live_attendance.live_meeting_id');
        $liveAttendanceModel->where('live_meetings.id', $meeting_id);
        $participants = $liveAttendanceModel->findAll();

        // Name file export
        $filename = "LiveSessionAttendance_" . $meeting_id . "_" . date('Y-m-d_His') . ".csv";

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
