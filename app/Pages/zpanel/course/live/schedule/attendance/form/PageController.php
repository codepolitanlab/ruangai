<?php

namespace App\Pages\zpanel\course\live\schedule\attendance\form;

use App\Controllers\BaseController;
use Exception;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Live Attendance Form';

        // Ambil ID dari URL jika ada
        $id              = $this->request->getGet('id');
        $live_meeting_id = $this->request->getGet('live_meeting_id');

        if ($id) {
            // Mode Edit: Ambil data scholarship
            $liveAttendance     = new \App\Models\LiveAttendance();
            $data['attendance'] = $liveAttendance
                ->select('live_attendance.*, users.name, users.email')
                ->join(('users'), 'users.id = live_attendance.user_id')
                ->where('live_attendance.deleted_at', null)
                ->where('live_attendance.id', $id)
                ->asObject()
                ->first();

            if (! $data['attendance']) {
                session()->setFlashdata('error', 'Data tidak ditemukan');

                return redirect()->to('/zpanel/course/live/schedule/attendance/' . $live_meeting_id);
            }

            $data['page_title'] = 'Edit Live Attendance Form';
        }

        $data['live_meeting'] = model('LiveMeetingModel')->where('id', $live_meeting_id)->asObject()->first();

        return pageView('zpanel/course/live/schedule/attendance/form/index', $data);
    }

    public function postIndex()
    {
        $id = $this->request->getPost('id');

        $user = model('UserModel')->where('email', $this->request->getPost('email'))->asObject()->first();

        if (! $user) {
            session()->setFlashdata('error', 'User tidak ditemukan');

            return redirect()->back()->withInput();
        }

        $data = [
            'live_meeting_id' => $this->request->getPost('live_meeting_id'),
            'course_id'       => 1,
            'user_id'         => $user->id,
            'duration'        => $this->request->getPost('duration'),
        ];

        $liveAttendanceModel = new \App\Models\LiveAttendance();

        try {
            if ($id) {
                // Update data
                $data['updated_at'] = date('Y-m-d H:i:s');
                $liveAttendanceModel->update($id, $data);
            } else {
                // Insert data baru
                $data['created_at'] = date('Y-m-d H:i:s');
                $liveAttendanceModel->insert($data);
            }

            session()->setFlashdata('success', 'Data berhasil disimpan');

            return redirect()->to('/zpanel/course/live/schedule/attendance/' . $data['live_meeting_id']);
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menyimpan data: ' . $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    public function postDelete()
    {
        $id                  = $this->request->getPost('id');
        $live_meeting_id     = $this->request->getPost('live_meeting_id');
        $liveAttendanceModel = new \App\Models\LiveAttendance();

        try {
            $liveAttendanceModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
            session()->setFlashdata('success', 'Data berhasil dihapus');
        } catch (Exception $e) {
            session()->setFlashdata('error', 'Gagal menghapus data: ' . $e->getMessage());
        }

        return redirect()->to('/zpanel/course/live/schedule/attendance/' . $live_meeting_id);
    }
}
