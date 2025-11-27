<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class WebhookController extends BaseController
{
    public function index()
    {
        $payload = $this->request->getPost();

        $data = [
            'user_id'         => $payload['user_id'],
            'live_meeting_id' => $payload['live_meeting_id'],
            'content'         => json_encode($payload),
            'created_at'      => date('Y-m-d H:i:s'),
        ];

        $db = \Config\Database::connect();
        $meetingFeedbackID = $db->table('live_meeting_feedback')->insert($data);

        $attendance = $db->table('live_attendance')
            ->select('live_attendance.*, course_students.course_id, course_students.progress, course_students.graduate')
            ->join('course_students', 'course_students.course_id = live_attendance.course_id')
            ->where('live_attendance.user_id', $payload['user_id'])
            ->where('live_meeting_id', $payload['live_meeting_id'])
            ->get()
            ->getRowArray();

        if (!$attendance) {
            return;
        }

        $courseStudentModel = model('Course\Models\CourseStudentModel');
        $attendanceId = $attendance['id'];
        $courseId = $attendance['course_id'];
        $userId = $payload['user_id'];

        // Cek kondisi kelulusan
        $isValidDuration = $attendance['duration'] >= 1800;
        $isProgressCompleted = $attendance['progress'] >= 100;
        $isNotGraduated = $attendance['graduate'] == 0;

        // Set meeting_feedback_id
        $updateData = [
            'meeting_feedback_id' => $meetingFeedbackID,
        ];

        // Tambahkan status jika durasi valid
        if ($isValidDuration) {
            $updateData['status'] = '1';
        }

        // Update data attendance
        $db->table('live_attendance')
            ->where('id', $attendanceId)
            ->update($updateData);

        // Tandai sebagai graduate jika memenuhi semua kondisi
        if ($isValidDuration && $isProgressCompleted && $isNotGraduated) {
            $courseStudentModel->markAsGraduate($userId, $courseId);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Feedback received',
            'data'    => $payload,
        ]);
    }
}
