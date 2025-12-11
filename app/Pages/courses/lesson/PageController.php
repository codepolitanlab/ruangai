<?php

namespace App\Pages\courses\lesson;

use App\Pages\BaseController;
use Symfony\Component\Yaml\Yaml;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Lessons',
        'module'     => 'courses',
        'submodule'  => 'course_lesson',
    ];

    public function getData($course_id, $lesson_id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken();

        if ($course_id === "1") {
            $this->data['module'] = 'misi_beasiswa';
        }

        $db = \Config\Database::connect();

        // Jika hanya ingin memastikan user terdaftar di course:
        // (a) Cara paling bersih: validasi di query terpisah sebelum ambil lesson
        $isEnrolled = $db->table('course_students')
            ->where('course_id', $course_id)
            ->where('user_id', $jwt->user_id)
            ->select('1', false)->limit(1)->get()->getRowArray();

        if (!$isEnrolled) {
            return $this->respond(['response_code' => 403, 'response_message' => 'Not enrolled']);
        }
        
        // Get specific lesson
        $lesson = $db->table('course_lessons')
            ->select('course_lessons.*, courses.course_title, courses.slug as course_slug, course_topics.topic_title')
            ->join('courses', 'courses.id = course_lessons.course_id')
            ->join('course_students', 'course_students.course_id = courses.id AND course_students.user_id = ' . $jwt->user_id)
            ->join('course_topics', 'course_topics.id = course_lessons.topic_id')
            ->where('course_lessons.course_id', $course_id)
            ->where('course_lessons.id', $lesson_id)
            ->where('course_lessons.deleted_at', null)
            ->limit(1)
            ->get()
            ->getRowArray();

        if ($lesson) {
            // Handle quiz format first
            if ($lesson['type'] === 'quiz' && $lesson['quiz']) {
                [$description, $questions, $answers] = $this->prepareQuiz($lesson['quiz']);

                $lesson['quiz_description'] = $description;
                $lesson['quiz']             = $questions;
            }

            // Set default video server
            $lesson['default_video_server'] = null;
            if ($lesson['video_diupload']) {
                $lesson['default_video_server'] = 'diupload';
            } elseif ($lesson['video_bunny']) {
                $lesson['default_video_server'] = 'bunny';
            }

            // Subquery untuk mendapatkan lesson yang sudah selesai
            $completedLessons = $db->table('course_lesson_progress')
                ->select('lesson_id')
                ->where('user_id', $jwt->user_id)
                ->where('course_id', $course_id)
                ->get()
                ->getResultArray();

            // Mengubah array hasil menjadi array sederhana berisi lesson_id
            $completedLessonIds = array_column($completedLessons, 'lesson_id');
            
            // Get last progress lesson (most recent lesson user interacted with)
            $lastProgress = $db->table('course_lesson_progress')
                ->select('lesson_id')
                ->where('user_id', $jwt->user_id)
                ->where('course_id', $course_id)
                ->orderBy('created_at', 'DESC')
                ->limit(1)
                ->get()
                ->getRowArray();
            
            $lastProgressLessonId = $lastProgress['lesson_id'] ?? null;

            // Query utama untuk mendapatkan semua lesson dengan urutan yang benar
            $lessons = $db->table('course_lessons')
                ->select('
                    course_lessons.id,
                    course_lessons.course_id,
                    course_lessons.lesson_title,
                    course_lessons.topic_id,
                    course_lessons.mandatory,
                    course_topics.topic_order,
                    course_lessons.lesson_order,
                    course_topics.topic_title,
                    course_lessons.free
                ')
                ->join('course_topics', 'course_topics.id = course_lessons.topic_id')
                ->where('course_lessons.course_id', $course_id)
                ->where('course_lessons.deleted_at', null)
                ->where('course_lessons.mandatory', 1)
                ->orderBy('course_topics.topic_order', 'ASC')
                ->orderBy('course_lessons.lesson_order', 'ASC')
                ->get()
                ->getResultArray();

            // Menambahkan status completed ke setiap lesson
            $orderedLessons = [];

            foreach ($lessons as $lessonItem) {
                $orderedLessons[] = array_merge($lessonItem, [
                    'is_completed' => in_array($lessonItem['id'], $completedLessonIds, true),
                ]);
            }

            // Group lessons by topic title for UI
            $lessonsGrouped = [];
            foreach ($orderedLessons as $l) {
                $lessonsGrouped[$l['topic_title']][] = $l;
            }

            $course['lessons'] = $orderedLessons;
            $course['lessons_grouped'] = $lessonsGrouped;
            $course['last_progress_lesson_id'] = $lastProgressLessonId;
            $lesson['is_completed'] = in_array($lesson['id'], $completedLessonIds, true);

            // Get previous and next lesson
            $IDs                   = array_column($course['lessons'], 'id');
            $currentIndexID        = array_search($lesson_id, $IDs, true);
            $prevLessonIndex       = $currentIndexID - 1;
            $nextLessonIndex       = $currentIndexID + 1;
            $lesson['prev_lesson'] = $course['lessons'][$prevLessonIndex] ?? null;
            $lesson['next_lesson'] = $course['lessons'][$nextLessonIndex] ?? null;

            // Fetch baseline course info (description, long_description if available in course_meta)
            $course_info = $db->table('courses')
                ->select('courses.*, course_meta.long_description')
                ->join('course_meta', 'course_meta.id = courses.id', 'left')
                ->where('courses.id', $course_id)
                ->get()
                ->getRowArray();

            // Get student progress
            $student = $db->table('course_students')
                ->select('progress, graduate')
                ->where('course_id', $course_id)
                ->where('user_id', $jwt->user_id)
                ->get()
                ->getRowArray();

            // merge course info and lessons
            if (! $course_info) {
                $course_info = [];
            }
            $course_info['lessons'] = $course['lessons'];
            $course_info['lessons_grouped'] = $course['lessons_grouped'];
            $course_info['last_progress_lesson_id'] = $lastProgressLessonId;
            $course_info['progress'] = $student['progress'] ?? 0;
            $course_info['graduate'] = $student['graduate'] ?? 0;
            $this->data['course'] = $course_info;
            $this->data['lesson'] = $lesson;

            // Get live sessions data
            $this->data['live_sessions'] = $this->getLiveSessions($course_id, $jwt->user_id, $db);

            return $this->respond($this->data);
        }

        return $this->respond([
            'response_code'    => 405,
            'response_message' => 'Kamu tidak memiliki akses ke lesson ini.',
        ]);
    }

    // Submit progress learning
    public function postIndex()
    {
        $data   = $this->request->getPost();
        $Heroic = new \App\Libraries\Heroic();

        $jwt       = $Heroic->checkToken();
        $course_id = $data['course_id'];
        $lesson_id = $data['lesson_id'];

        $result = $this->writeProgress($jwt->user_id, $course_id, $lesson_id);

        return $this->respond($result);
    }

    public function postQuiz()
    {
        $data   = $this->request->getPost();
        $Heroic = new \App\Libraries\Heroic();

        $jwt = $Heroic->checkToken();

        $course_id    = $data['course_id'];
        $lesson_id    = $data['lesson_id'];
        $user_answers = json_decode($data['answers'], true);

        $db     = \Config\Database::connect();
        $lesson = $db->table('course_lessons')
            ->select('quiz')
            ->where('course_lessons.id', $lesson_id)
            ->where('course_lessons.course_id', $course_id)
            ->get()
            ->getRowArray();

        [$description, $questions, $rightAnswers] = $this->prepareQuiz($lesson['quiz']);

        $hasil = [];
        $benar = 0;

        foreach ($rightAnswers as $id => $kunci) {
            $jawabanUser = $user_answers[$id] ?? null;

            // Normalisasi untuk tipe true_false (string 'true'/'false' ke boolean)
            if (is_bool($kunci['value'])) {
                $jawabanUser = $jawabanUser === 'true' ? true : false;
            }

            $isCorrect  = $jawabanUser === $kunci['value'];
            $hasil[$id] = [
                'jawaban'    => $user_answers[$id] ?? null,
                'benar'      => $isCorrect,
                'penjelasan' => $isCorrect ? $kunci['explanation'] : null,
            ];

            if ($isCorrect) {
                $benar++;
            }
        }

        $score        = $benar / count($rightAnswers) * 100;
        $minimumScore = 75;
        $isPass       = $score >= $minimumScore;

        if ($isPass) {
            $this->writeProgress($jwt->user_id, $course_id, $lesson_id);
        }

        return $this->respond([
            'hasil'     => $hasil,
            'benar'     => $benar,
            'score'     => min($score, 100), // Pastikan score tidak lebih dari 100%
            'is_pass'   => $isPass,
            'min_score' => $minimumScore,
        ]);
    }

    // Write progress learning
    private function writeProgress($user_id, $course_id, $lesson_id)
    {
        $db = \Config\Database::connect();

        $lesson = $db->table('course_lessons')
            ->select('courses.id as course_id, courses.slug as course_slug, course_lessons.mandatory')
            ->join('courses', 'courses.id = course_lessons.course_id')
            ->where('course_lessons.id', $lesson_id)
            ->where('course_lessons.course_id', $course_id)
            ->where('course_lessons.status', 1)
            ->where('course_lessons.deleted_at', null)
            ->get()
            ->getRowArray();

        if (! $lesson) {
            return [
                'status'  => 'failed',
                'message' => 'Course tidak ditemukan atau tidak tersedia',
            ];
        }

        // Check if the user has already completed this lesson
        $existingProgress = $db->table('course_lesson_progress')
            ->where('user_id', $user_id)
            ->where('lesson_id', $lesson_id)
            ->where('course_id', $lesson['course_id'])
            ->get()
            ->getRowArray();

        if (! $existingProgress) {
            // Insert new progress record
            $progressData = [
                'user_id'   => $user_id,
                'lesson_id' => $lesson_id,
                'course_id' => $lesson['course_id'],
            ];

            $inserted = $db->table('course_lesson_progress')->insert($progressData);

            if ($inserted) {
                // Update progress di course_students hanya jika lesson mandatory
                if ($lesson['mandatory'] == 1) {
                    $this->updateCourseProgress($user_id, $lesson['course_id']);
                }

                return [
                    'status'  => 'success',
                    'message' => 'Berhasil menyelesaikan materi',
                    'course'  => $lesson,
                ];
            }

            return [
                'status'  => 'failed',
                'message' => 'Gagal menyelesaikan materi',
            ];
        }
    }

    // Update progress di course_students
    private function updateCourseProgress($user_id, $course_id)
    {
        $db = \Config\Database::connect();

        // Hitung progress course (hanya lesson mandatory)
        $totalQuery = $db->table('course_lessons')
            ->select('course_lessons.id, course_lesson_progress.lesson_id')
            ->where('course_lessons.course_id', $course_id)
            ->where('course_lessons.mandatory', 1)
            ->join('course_lesson_progress', 'course_lesson_progress.lesson_id = course_lessons.id AND course_lesson_progress.user_id = ' . $user_id, 'left')
            ->get()
            ->getResultArray();

        $totalLessons     = count($totalQuery);
        $completedLessons = 0;

        foreach ($totalQuery as $row) {
            if ($row['lesson_id'] !== null) {
                $completedLessons++;
            }
        }

        // Pastikan progress tidak lebih dari 100%
        $progress = min(($completedLessons / $totalLessons) * 100, 100);

        // Update atau insert ke course_students
        $existingStudent = $db->table('course_students')
            ->where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->get()
            ->getRowArray();

        $studentData = [
            'user_id'         => $user_id,
            'course_id'       => $course_id,
            'progress'        => $progress,
            'progress_update' => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ];

        if ($existingStudent) {
            $db->table('course_students')
                ->where('user_id', $user_id)
                ->where('course_id', $course_id)
                ->update($studentData);
        } else {
            $studentData['created_at'] = date('Y-m-d H:i:s');
            $studentData['updated_at'] = null;
            $db->table('course_students')->insert($studentData);
        }
    }

    // Parse quiz into [$questions, $answers]
    private function prepareQuiz($yaml)
    {
        $arrayQuiz = Yaml::parse($yaml);

        $description = $arrayQuiz['description'];
        $questions   = [];
        $answers     = [];

        foreach ($arrayQuiz['quiz'] as $item) {
            $hash             = substr(md5($item['question']), -6);
            $questions[$hash] = [
                'type'     => $item['type'],
                'question' => $item['question'],
                'options'  => $item['options'] ?? [],
            ];
            $answers[$hash] = [
                'value'       => $item['answer'],
                'explanation' => $item['explanation'] ?? null,
            ];
        }

        return [$description, $questions, $answers];
    }

    private function getLiveSessions($course_id, $user_id, $db)
    {
        // Get attended events
        $attendedQuery = $db->table('live_attendance')
            ->select('live_meeting_id, live_meetings.meeting_code, live_meetings.title, 
            live_meetings.subtitle, live_meetings.theme_code, duration, meeting_feedback_id, 
            meeting_date, meeting_time, live_batch.name as batch_title, 
            live_attendance.status')
            ->join('live_meetings', 'live_meetings.id = live_attendance.live_meeting_id')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('live_attendance.course_id', $course_id)
            ->where('user_id', $user_id)
            ->orderBy('live_meetings.meeting_date', 'asc')
            ->get()
            ->getResultArray();

        $attended = [];
        $attendedCode = [];
        if ($attendedQuery) {
            $attended = array_column($attendedQuery, 'live_meeting_id');
            foreach ($attendedQuery as $value) {
                if ($value['status'] === '1') {
                    $attendedCode[] = $value['theme_code'];
                }
            }
        }

        $live_sessions = $db->table('live_meetings')
            ->select('live_meetings.*, live_batch.name as batch_title')
            ->join('live_batch', 'live_batch.id = live_meetings.live_batch_id')
            ->where('live_batch.status', 'ongoing')
            ->where('live_batch.course_id', $course_id)
            ->where('live_meetings.deleted_at', null)
            ->orderBy('meeting_date', 'ASC')
            ->orderBy('meeting_time', 'ASC')
            ->get()
            ->getResultArray();

        $result = [
            'scheduled' => [],
            'ongoing' => [],
            'completed' => [],
            'attended' => []
        ];

        if ($live_sessions) {
            foreach ($live_sessions as $live_session) {
                $feedbackExists = $db->table('live_meeting_feedback')
                    ->where('user_id', $user_id)
                    ->where('live_meeting_id', $live_session['id'])
                    ->countAllResults() > 0;

                $live_session['feedback_submitted'] = $feedbackExists;

                // Determine status_date
                if (date('Y-m-d') === $live_session['meeting_date']) {
                    if (date('H:i:s') > date('H:i:s', strtotime('+2 hours', strtotime($live_session['meeting_time'])))) {
                        $live_session['status_date'] = in_array($live_session['id'], $attended) ? 'attended' : 'completed';
                    } elseif (date('H:i:s') < $live_session['meeting_time']) {
                        $live_session['status_date'] = 'upcoming';
                    } else {
                        $live_session['status_date'] = 'ongoing';
                    }
                } elseif (date('Y-m-d') > $live_session['meeting_date']) {
                    $live_session['status_date'] = in_array($live_session['id'], $attended) ? 'attended' : 'completed';
                } else {
                    $live_session['status_date'] = 'upcoming';
                }

                // Pack into categories
                if ($live_session['status_date'] === 'ongoing') {
                    $result['ongoing'][] = $live_session;
                } elseif ($live_session['status_date'] === 'attended') {
                    $result['attended'][] = $live_session;
                } elseif ($live_session['status_date'] === 'completed') {
                    $result['completed'][] = $live_session;
                } else {
                    $result['scheduled'][] = $live_session;
                }
            }
        }

        return $result;
    }
}
