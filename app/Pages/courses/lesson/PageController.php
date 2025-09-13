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

        if($course_id === "1") {
            $this->data['module'] = 'misi_beasiswa';
        }

        $db = \Config\Database::connect();
        // Get specific lesson
        $lesson = $db->table('course_lessons')
            ->select('course_lessons.*, courses.course_title, courses.slug as course_slug, course_topics.topic_title')
            ->join('courses', 'courses.id = course_lessons.course_id')
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

            // Query utama untuk mendapatkan semua lesson dengan urutan yang benar
            $lessons = $db->table('course_lessons')
                ->select('
                    course_lessons.id,
                    course_lessons.lesson_title,
                    course_lessons.topic_id,
                    course_topics.topic_order,
                    course_lessons.lesson_order,
                    course_topics.topic_title
                ')
                ->join('course_topics', 'course_topics.id = course_lessons.topic_id')
                ->where('course_lessons.course_id', $course_id)
                ->where('course_lessons.deleted_at', null)
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

            $course['lessons']      = $orderedLessons;
            $lesson['is_completed'] = in_array($lesson['id'], $completedLessonIds, true);

            // Get previous and next lesson
            $IDs                   = array_column($course['lessons'], 'id');
            $currentIndexID        = array_search($lesson_id, $IDs, true);
            $prevLessonIndex       = $currentIndexID - 1;
            $nextLessonIndex       = $currentIndexID + 1;
            $lesson['prev_lesson'] = $course['lessons'][$prevLessonIndex] ?? null;
            $lesson['next_lesson'] = $course['lessons'][$nextLessonIndex] ?? null;

            $this->data['course'] = $course;
            $this->data['lesson'] = $lesson;

            return $this->respond($this->data);
        }

        return $this->respond([
            'response_code'    => 404,
            'response_message' => 'Not found',
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

        $course = $db->table('course_lessons')
            ->select('courses.id as course_id, courses.slug as course_slug')
            ->join('courses', 'courses.id = course_lessons.course_id')
            ->where('course_lessons.id', $lesson_id)
            ->where('course_lessons.course_id', $course_id)
            ->get()
            ->getRowArray();

        if (! $course) {
            return [
                'status'  => 'failed',
                'message' => 'Course tidak ditemukan',
            ];
        }

        // Check if the user has already completed this lesson
        $existingProgress = $db->table('course_lesson_progress')
            ->where('user_id', $user_id)
            ->where('lesson_id', $lesson_id)
            ->where('course_id', $course['course_id'])
            ->get()
            ->getRowArray();

        if (! $existingProgress) {
            // Insert new progress record
            $progressData = [
                'user_id'   => $user_id,
                'lesson_id' => $lesson_id,
                'course_id' => $course['course_id'],
            ];

            $inserted = $db->table('course_lesson_progress')->insert($progressData);

            if ($inserted) {
                // Update progress di course_students
                $this->updateCourseProgress($user_id, $course['course_id']);

                return [
                    'status'  => 'success',
                    'message' => 'Berhasil menyelesaikan materi',
                    'course'  => $course,
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

        // Hitung progress course
        $totalQuery = $db->table('course_lessons')
            ->select('course_lessons.id, course_lesson_progress.lesson_id')
            ->where('course_lessons.course_id', $course_id)
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
}
