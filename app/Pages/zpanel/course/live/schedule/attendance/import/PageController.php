<?php

namespace App\Pages\zpanel\course\live\schedule\attendance\import;

use App\Controllers\BaseController;
use App\Models\LiveAttendance;
use App\Models\UserModel;

class PageController extends BaseController
{
    public function getIndex($live_meeting_id = null)
    {
        $data['page_title'] = "Import Live Attenders";

        // Ambil ID dari URL jika ada
        $live_meeting_id = $live_meeting_id ?? $this->request->getGet('live_meeting_id');
        $data['live_meeting_id'] = $live_meeting_id;

        // Get live meeting, its batch, and course
        $db = \Config\Database::connect();
        $data['live_meeting'] = $db->table('live_meetings')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->join('courses', 'courses.id = live_batch.course_id')
            ->where('live_meetings.id', $live_meeting_id)
            ->get()
            ->getRow();

        return pageView('zpanel/course/live/schedule/attendance/import/index', $data);
    }

    public function postIndex($live_meeting_id = null)
    {
        $file = $this->request->getFile('userfile');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $live_meeting_id = $live_meeting_id ?? $this->request->getGet('live_meeting_id');
        $data['live_meeting_id'] = $live_meeting_id;

        $db = \Config\Database::connect();
        $live_meeting = $db->table('live_meetings')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->join('courses', 'courses.id = live_batch.course_id')
            ->where('live_meetings.id', $live_meeting_id)
            ->get()
            ->getRowArray();

        $User = new \App\Models\UserModel();
        $Attendance = new \App\Models\LiveAttendance();

        $handle = fopen($file->getTempName(), 'r');
        $header = fgetcsv($handle); // skip header

        $imported = 0;
        $skipped = 0;
        $notFoundEmails = [];

        while (($row = fgetcsv($handle)) !== false) {
            $email = strtolower(trim($row[0]));
            $duration = (int) trim($row[1]);

            $user = $User->where('LOWER(email)', strtolower($email))->first();
            if (!$user) {
                $notFoundEmails[] = $email;
                continue;
            }

            // Cek apakah sudah ada data attendance untuk user dan meeting ini
            $exists = $Attendance->where([
                'user_id' => $user['id'],
                'live_meeting_id' => $live_meeting_id,
            ])->first();

            if ($exists) {
                $skipped++;
                continue;
            }

            $Attendance->insert([
                'course_id'       => $live_meeting['course_id'],
                'live_meeting_id' => $live_meeting_id,
                'user_id'         => $user['id'],
                'duration'        => $duration ?? 0
            ]);
            $imported++;
        }
        fclose($handle);

        $message = "Import selesai. $imported data berhasil disimpan.";
        if ($skipped > 0) {
            $message .= " $skipped data dilewati karena sudah ada.";
        }
        if (count($notFoundEmails) > 0) {
            $message .= "<br>Data tidak ditemukan untuk email berikut:<br><ul>";
            foreach ($notFoundEmails as $email) {
                $message .= "<li>$email</li>";
            }
            $message .= "</ul>";
        }

        session()->setFlashdata('success', $message);
        return redirectPage('zpanel/course/live/schedule/attendance/' . $live_meeting_id);
    }
}
