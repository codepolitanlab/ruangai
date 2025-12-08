<?php

namespace App\Pages\courses\intro\lessons;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Daftar Materi',
        'module'      => 'courses',
        'active_page' => 'materi',
    ];

    public function getData($id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        $db = \Config\Database::connect();

        // Get course
        if (! $course = cache('course_' . $id)) {
            $course = $db->table('courses')
                ->where('id', $id)
                ->get()
                ->getRowArray();

            // Save into the cache for 5 minutes
            cache()->save('course_' . $id, $course, 3600);
        }
        $this->data['course'] = $course;

        if ($course) {
            if ($course['id'] == 1) {
                $this->data['module'] = 'misi_beasiswa';
            }

            // Jika hanya ingin memastikan user terdaftar di course:
            // (a) Cara paling bersih: validasi di query terpisah sebelum ambil lesson
            $isEnrolled = $db->table('course_students')
                ->where('course_id', $course['id'])
                ->where('user_id', $jwt->user_id)
                ->select('1', false)->limit(1)->get()->getRowArray();

            if (!$isEnrolled) {
                return $this->respond(['response_code' => 403, 'response_message' => 'Not enrolled']);
            }

            // Get completed lessons for current user
            $completedLessons = $db->table('course_lesson_progress')
                ->select('lesson_id')
                ->where('user_id', $jwt->user_id)
                ->where('course_id', $id)
                ->get()
                ->getResultArray();

            $completedLessonIds = array_column($completedLessons, 'lesson_id');

            // Get lessons for this course
            if (! $lessons = cache('course_' . $id . '_lessons')) {
                $lessons = $db->table('course_lessons')
                    ->select('course_lessons.*, course_topics.topic_title, course_topics.topic_slug, course_topics.topic_order, course_topics.free as topic_free, course_topics.status as topic_status, course_lessons.id as id, course_lessons.mandatory as mandatory')
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
            $numCompletedMandatory = 0;
            $topicsMandatory  = [];

            foreach ($lessons as $key => $lesson) {
                // Tambahkan status is_completed ke setiap lesson
                $this->data['course']['lessons'][$lesson['topic_title']][] = $lesson;
                
                // Track if any lesson in this topic is mandatory=0 (opsional)
                if (!isset($topicsMandatory[$lesson['topic_title']])) {
                    $topicsMandatory[$lesson['topic_title']] = true; // default mandatory
                }
                if ($lesson['mandatory'] == 0) {
                    $topicsMandatory[$lesson['topic_title']] = false; // ada lesson opsional
                }
                
                $lessonsCompleted[] = [
                    'id'        => $lesson['id'],
                    'completed' => in_array($lesson['id'], $completedLessonIds, true),
                    'mandatory' => $lesson['mandatory'],
                ];
                if (in_array($lesson['id'], $completedLessonIds, true)) {
                    $numCompleted++;
                    // Hitung yang mandatory saja
                    if ($lesson['mandatory'] == 1) {
                        $numCompletedMandatory++;
                    }
                }
            }
            $this->data['lessonsCompleted'] = $lessonsCompleted;
            $this->data['topicsMandatory']  = $topicsMandatory;
            $this->data['numCompleted']     = $numCompletedMandatory;

            // Get course_students
            $this->data['student'] = $db->table('course_students')
                ->select('progress, cert_claim_date, cert_code, expire_at')
                ->where('course_id', $id)
                ->where('user_id', $jwt->user_id)
                ->get()
                ->getRowArray();
            $this->data['is_expire'] = $this->data['student']['expire_at'] && $this->data['student']['expire_at'] < date('Y-m-d H:i:s') ? true : false;

            return $this->respond($this->data);
        }

        return $this->respond([
            'response_code'    => 404,
            'response_message' => 'Not found',
        ]);
    }
}
