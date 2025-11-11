<?php

namespace App\Pages\courses\intro;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Detail Kelas',
        'module'      => 'courses',
        'active_page' => 'intro',
    ];

    public function getData($id)
    {
        $Heroic             = new \App\Libraries\Heroic();
        $jwt                = $Heroic->checkToken(true);
        $this->data['name'] = $jwt->user['name'];

        $db = \Config\Database::connect();

        // Get course
        // if (! $course = cache('course_' . $id)) {
        $course = $db->table('courses')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        // Save into the cache for 5 minutes
        // cache()->save('course_' . $id, $course, 300);
        // }

        if ($course) {
            if ($course['id'] == 1) {
                $this->data['module'] = 'misi_beasiswa';
            }

            // Get completed lessons for current user
            $completedLessons = $db->table('course_lessons')
                ->select('count(course_lessons.id) as total_lessons, count(course_lesson_progress.user_id) as completed')
                ->join('course_lesson_progress', 'course_lesson_progress.lesson_id = course_lessons.id AND user_id = ' . $jwt->user_id, 'left')
                ->where('course_lessons.course_id', $id)
                ->get()
                ->getRowArray();

            $this->data['total_lessons']    = $completedLessons['total_lessons'] ?? 1;
            $this->data['lesson_completed'] = $completedLessons['completed'] ?? 0;
            $this->data['course']           = $course;

            // Get count live attendance user
            $this->data['live_attendance'] = $db->table('live_attendance')
                ->where('user_id', $jwt->user_id)
                ->where('course_id', $id)
                ->where('status', 1)
                ->where('deleted_at', null)
                ->countAllResults();

            // Get total live_meetings
            $this->data['live_meetings'] = $db->table('live_meetings')
                ->select('live_meetings.id')
                ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
                ->where('course_id', $id)
                ->countAllResults();

            // Get course_students
            $this->data['student'] = $db->table('course_students')
                ->select('progress, expire_at, scholarship_participants.reference')
                ->join('scholarship_participants', 'scholarship_participants.user_id = course_students.user_id', 'left')
                ->where('course_students.course_id', $id)
                ->where('course_students.user_id', $jwt->user_id)
                ->get()
                ->getRowArray();

            $certificate = $db->table('certificates')
                ->where('user_id', $jwt->user_id)
                ->where('entity_id', $id)
                ->get()
                ->getRowArray();

            $this->data['certificate_id'] = $certificate ? $certificate['id'] : false;

            if ($this->data['student']) {
                $this->data['course_completed'] = $this->data['total_lessons'] === $this->data['lesson_completed'] && $this->data['live_attendance'] > 0 ? true : false;
                $this->data['is_enrolled']      = $db->table('course_students')->where('course_id', $id)->where('user_id', $jwt->user_id)->countAllResults() > 0 ? true : false;
                $this->data['is_expire']        = $this->data['student']['expire_at'] && $this->data['student']['expire_at'] < date('Y-m-d H:i:s') ? true : false;
            } else {
                $this->data['course_completed'] = false;
                $this->data['is_enrolled']      = false;
                $this->data['is_expire']        = false;
            }


            // Get completed lessons for current user
            $completed = $db->table('course_lesson_progress')
                ->select('lesson_id')
                ->where('user_id', $jwt->user_id)
                ->where('course_id', $id)
                ->get()
                ->getResultArray();

            $completedLessonIds = array_column($completed, 'lesson_id');

            // Get lessons for this course
            if (! $lessons = cache('course_' . $id . '_lessons')) {
                $lessons = $db->table('course_lessons')
                    ->select('course_lessons.*, course_topics.*, course_lessons.id as id')
                    ->join('course_topics', 'course_topics.id = course_lessons.topic_id', 'left')
                    ->where('course_lessons.course_id', $id)
                    ->where('course_lessons.deleted_at', null)
                    ->orderBy('course_topics.topic_order', 'ASC')
                    ->orderBy('course_lessons.lesson_order', 'ASC')
                    ->get()
                    ->getResultArray();

                // Save into the cache for 1 hours
                cache()->save('course_' . $id . '_lessons', $lessons, 3600);
            }

            $lessonsCompleted = [];
            $numCompleted     = 0;

            foreach ($lessons as $key => $lesson) {
                // Tambahkan status is_completed ke setiap lesson
                $this->data['course']['lessons'][$lesson['topic_title']][] = $lesson;
                $lessonsCompleted[] = [
                    'id'        => $lesson['id'],
                    'completed' => in_array($lesson['id'], $completedLessonIds, true),
                ];
                if (in_array($lesson['id'], $completedLessonIds, true)) {
                    $numCompleted++;
                }
            }

            $this->data['is_comentor'] = $jwt->user['role_id'] == 4 ? true : false;
            $this->data['group_comentor'] = null;
            if ($this->data['student']['reference'] ?? null) {
                $this->data['group_comentor'] = $db->table('shorteners')
                    ->where('code', $this->data['student']['reference'])
                    ->get()
                    ->getRowArray();
            }

            return $this->respond($this->data);
        }

        return $this->respond([
            'response_code'    => 404,
            'response_message' => 'Not found',
        ]);
    }

    public function postHeregister()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        // Update expire_at to null
        $db = \Config\Database::connect();
        $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->where('course_id', $this->request->getPost('course_id'))
            ->update([
                'expire_at' => null
            ]);

        $courseStudent = $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->where('course_id', $this->request->getPost('course_id'))
            ->get()
            ->getRowArray();

        if ($courseStudent['graduate'] !== '1') {
            // Update field program in scholarship_participants to Active program
            $activeProgram = $db->table('events')
                ->select('code')
                ->where('status', 'ongoing')
                ->get()
                ->getRowArray()['code'] ?? null;

            $db->table('scholarship_participants')
                ->where('user_id', $jwt->user_id)
                ->update([
                    'program' => $activeProgram
                ]);
        }

        return $this->respond([
            'response_code'    => 200,
            'response_message' => 'Success',
        ]);
    }
}
