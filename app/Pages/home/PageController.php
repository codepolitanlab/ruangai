<?php

namespace App\Pages\home;

use App\Pages\BaseController;
use Firebase\JWT\JWT;

class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Homepage',
        'module'      => 'homepage',
        'active_page' => 'homepage',
        'body_class'  => 'rd-dashboard-page',
    ];

    public function getData()
    {
        helper('scholarship');
        
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);
        $this->data['name'] = $jwt->user['name'];
        $this->data['email'] = $jwt->user['email'] ?? '';
        $this->data['isValidEmail'] = (bool) ($jwt->user['email_valid'] ?? false);

        $db = \Config\Database::connect();
        
        // Check if user is scholarship participant
        if (! function_exists('is_scholarship_participant')) helper('scholarship');
        $this->data['is_scholarship_participant'] = \is_scholarship_participant($jwt->user_id);

        $this->data['courses'] = $db->table('course_students')
            ->where('user_id', $jwt->user_id)
            ->countAllResults();

        // ===== Online course (tabel courses) — kartu ungu =====
        $onlineCourses = $db->table('course_students')
            ->select('courses.id, courses.course_title, courses.slug, courses.cover, courses.description, courses.total_module, course_students.progress, course_students.graduate')
            ->join('courses', 'courses.id = course_students.course_id')
            ->where('course_students.user_id', $jwt->user_id)
            ->where('course_students.deleted_at', null)
            ->orderBy('course_students.created_at', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($onlineCourses as &$course) {
            $course['total_module'] = (int) ($course['total_module'] ?? 0);
            $course['is_live']      = false;
            $course['batch_name']   = null;
            // Kelas Misi Beasiswa (GenAI, courses.id = 1) dibuka lewat halaman beasiswa/intro
            $course['is_beasiswa']  = ((int) $course['id'] === 1);
        }
        unset($course);

        // ===== Live session / kelas bootcamp (tabel cls_*) — kartu hijau =====
        $liveSessions = $db->table('cls_classes c')
            ->select('c.id, c.name, c.thumbnail, c.description, c.start_date, cm.enrolled_at, s.name AS syllabus_name')
            ->join('cls_class_members cm', 'cm.class_id = c.id AND cm.user_id = ' . (int) $jwt->user_id)
            ->join('cls_syllabuses s', 's.id = c.syllabus_id', 'left')
            ->where('cm.status', 'active')
            ->where('c.status', 'active')
            ->where('c.deleted_at IS NULL')
            ->orderBy('c.start_date', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($liveSessions as &$cls) {
            $cls['is_live']         = true;
            $cls['course_title']    = $cls['name'];
            $cls['total_materials'] = (int) $db->table('cls_class_materials')
                ->where('class_id', $cls['id'])
                ->countAllResults();
            // Batch diambil dari akhiran nama kelas, mis. "Bootcamp Vibe Coding — Batch 1"
            $cls['batch_name']      = preg_match('/[—–-]\s*(.+)$/u', $cls['name'], $m) ? trim($m[1]) : null;
            unset($cls['name']);
        }
        unset($cls);

        // Gabung: live session tampil lebih dulu, lalu online course
        $this->data['my_courses'] = array_merge($liveSessions, $onlineCourses);

        $this->data['total_live_session'] = $db->table('live_attendance')
            ->where('user_id', $jwt->user_id)
            ->where('status', 1)
            ->countAllResults();

        $last_course = $db->table('course_lesson_progress')
            ->select('course_id as id, courses.course_title as title, courses.slug')
            ->join('courses', 'courses.id = course_lesson_progress.course_id')
            ->where('course_lesson_progress.user_id', $jwt->user_id)
            ->orderBy('course_lesson_progress.created_at', 'DESC')
            ->get()
            ->getRowArray();

        if (!$last_course) {
            $last_course = $db->table('courses')
                ->select('id, course_title as title, slug')
                ->where('id', 1)
                ->get()
                ->getRowArray();
        }

        // Get completed lessons for current user (only mandatory lessons)
        $completedLessons = $db->table('course_lessons')
            ->select('count(course_lessons.id) as total_lessons, count(course_lesson_progress.user_id) as completed')
            ->join('course_lesson_progress', 'course_lesson_progress.lesson_id = course_lessons.id AND user_id = ' . $jwt->user_id, 'left')
            ->where('course_lessons.course_id', $last_course['id'])
            ->where('course_lessons.mandatory', 1)
            ->get()
            ->getRowArray();

        $this->data['last_course']                     = $last_course;
        $this->data['last_course']['total_lessons']    = $completedLessons['total_lessons'] ?? 1;
        $this->data['last_course']['lesson_completed'] = $completedLessons['completed'] ?? 0;

        // ===== Terakhir dipelajari (kursus online & bootcamp) =====
        // Dipindah dari halaman /kelas.
        $this->data['last_studied'] = $this->lastStudied($db, (int) $jwt->user_id);

        // Get course_students - safe for non-scholarship users
        $this->data['student'] = $db->table('course_students')
            ->select('progress, expire_at, graduate, scholarship_participants.program, scholarship_participants.reference, scholarship_participants.reference_comentor, certificates.cert_claim_date, certificates.cert_code')
            ->join('scholarship_participants', 'scholarship_participants.user_id = course_students.user_id', 'left')
            ->join('certificates', 'certificates.user_id = course_students.user_id AND certificates.entity_id = course_students.course_id', 'left')
            ->where('course_students.course_id', 1)
            ->where('course_students.user_id', $jwt->user_id)
            ->get()
            ->getRowArray();

        // Safe null handling untuk user kompetisi
        $this->data['event'] = $db->table('scholarship_events')
            ->select('date_start, date_end, code')
            ->where('status', 'ongoing')
            ->get()
            ->getRowArray();
        
        $this->data['group_comentor'] = null;

        $this->data['is_expire'] = ($this->data['student'] && isset($this->data['student']['expire_at']) && $this->data['student']['expire_at'] < date('Y-m-d H:i:s')) ? true : false;

        if ($this->data['student'] && isset($this->data['student']['reference'])) {
            $this->data['group_comentor'] = $db->table('shorteners')
                ->where('code', $this->data['student']['reference'])
                ->get()
                ->getRowArray();
        }

        $this->data['is_comentor'] = $jwt->user['role_id'] == 4 ? true : false;
        $this->data['scholarship_url'] = scholarship_registration_url($jwt->user_id);
        $this->data['student']['graduate'] = $this->data['student'] && isset($this->data['student']['graduate']) && $this->data['student']['graduate'] === '1' ? true : false;

        return $this->respond($this->data);
    }

    public function postSendEmailVerification()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db = \Config\Database::connect();

        $email = $this->request->getPost('email');
        if (! $email) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Email is required',
            ]);
        }

        $exists = $db->table('users')
            ->where('email', $email)
            ->where('id !=', $jwt->user_id)
            ->get()
            ->getRowArray();

        if ($exists) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Email sudah digunakan',
            ]);
        }

        $user = $db->table('users')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        if (! $user) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'User not found',
            ]);
        }

        // === RATE LIMITING: minimum 60 detik cooldown ===
        $cache = \Config\Services::cache();
        $cooldownKey = 'otp_cooldown_' . $jwt->user_id;
        $lastSent = $cache->get($cooldownKey);

        if ($lastSent !== null) {
            $elapsed = time() - $lastSent;
            if ($elapsed < 60) {
                $remaining = 60 - $elapsed;
                return $this->respond([
                    'status'  => 'failed',
                    'message' => "Mohon tunggu {$remaining} detik sebelum mengirim ulang OTP.",
                ]);
            }
        }

        // === RATE LIMITING: max 5 OTP per jam per user ===
        $hourlyKey = 'otp_hourly_' . $jwt->user_id . '_' . date('YmdH');
        $hourlyCount = (int) $cache->get($hourlyKey);
        if ($hourlyCount >= 2) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Terlalu banyak permintaan OTP. Silakan coba lagi nanti.',
            ]);
        }

        // set update otp_email on users
        helper('text');
        $otp    = random_string('numeric', 6);
        $update = $db->table('users')
            ->where('id', $jwt->user_id)
            ->update([
                'otp_email' => $otp,
            ]);

        if (! $update) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Failed to update OTP',
            ]);
        }

        // Simpan timestamp pengiriman OTP ke cache
        $cache->save($cooldownKey, time(), 300);
        $cache->save($hourlyKey, $hourlyCount + 1, 3600);

        $body = [
            'name' => $user['name'],
            'otp'  => $otp,
        ];

        $EmailSender = new \App\Libraries\EmailSender();
        $EmailSender->setTemplate('email_activation', $body);
        $EmailSender->send($email, 'Email Verification');

        return $this->respond([
            'status'  => 'success',
            'message' => 'OTP has been sent to your email',
        ]);
    }

    public function postVerifyEmail()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);

        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');

        $exists = $db->table('users')
            ->where('email', $email)
            ->where('id !=', $jwt->user_id)
            ->get()
            ->getRowArray();

        if ($exists) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Email sudah digunakan',
            ]);
        }

        $user = $db->table('users')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        if ($user['otp_email'] !== $this->request->getPost('otp')) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Invalid OTP',
            ]);
        }

        $db->table('users')
            ->where('id', $jwt->user_id)
            ->update([
                'email_valid' => 1,
                'otp_email'   => null,
                'email'       => $email,
            ]);
        
        // Update scholarship_participants only if user is participant
        helper('scholarship');
        if (\is_scholarship_participant($jwt->user_id)) {
            $db->table('scholarship_participants')
                ->where('user_id', $jwt->user_id)
                ->update([
                    'email' => $email,
                ]);
        }

        $newJwt = JWT::encode([
            'user_id'      => $user['id'],
            'isValidEmail' => 1,
            'exp'          => time() + 7 * 24 * 60 * 60,
        ], config('Heroic')->jwtKey['secret'], 'HS256');

        return $this->respond([
            'status'  => 'success',
            'message' => 'Email has been verified',
            'jwt'     => $newJwt,
        ]);
    }

    /**
     * Item yang terakhir dipelajari user: kursus online (course_lesson_progress)
     * atau bootcamp (cls_learning_progress). Yang paling baru yang dipakai.
     */
    private function lastStudied($db, int $userId): ?array
    {
        $candidates = [];

        // Kursus online → lesson terakhir yang dibuka
        $online = $db->table('course_lesson_progress p')
            ->select('p.course_id, p.created_at, courses.course_title, courses.slug, courses.cover, courses.thumbnail')
            ->join('courses', 'courses.id = p.course_id')
            ->join('course_students', 'course_students.course_id = p.course_id AND course_students.user_id = ' . $userId)
            ->where('p.user_id', $userId)
            ->where('courses.deleted_at', null)
            ->orderBy('p.created_at', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        if ($online) {
            $courseId = (int) $online['course_id'];

            // Progres = modul wajib yang selesai / total modul wajib
            $stat = $db->table('course_lessons cl')
                ->select('COUNT(DISTINCT cl.id) AS total, COUNT(DISTINCT lp.id) AS completed')
                ->join('course_lesson_progress lp', 'lp.lesson_id = cl.id AND lp.user_id = ' . $userId, 'left')
                ->where('cl.course_id', $courseId)
                ->where('cl.mandatory', 1)
                ->get()
                ->getRowArray();

            $total = (int) ($stat['total'] ?? 0);
            $done  = (int) ($stat['completed'] ?? 0);

            $candidates[] = [
                'time' => (string) $online['created_at'],
                'item' => [
                    'title'     => $online['course_title'],
                    'thumbnail' => $online['thumbnail'] ?: $online['cover'],
                    'progress'  => $total > 0 ? (int) round(($done / $total) * 100) : 0,
                    'url'       => '/courses/intro/' . $courseId . '/' . ($online['slug'] ?? ''),
                ],
            ];
        }

        // Bootcamp → resource terakhir yang dikerjakan
        $live = $db->table('cls_learning_progress p')
            ->select('cm.class_id, p.created_at, c.name, c.thumbnail')
            ->join('cls_class_materials cm', 'cm.id = p.class_material_id')
            ->join('cls_classes c', 'c.id = cm.class_id')
            ->join('cls_class_members m', "m.class_id = cm.class_id AND m.user_id = {$userId} AND m.status = 'active'")
            ->where('p.user_id', $userId)
            ->where('c.deleted_at IS NULL')
            ->orderBy('p.created_at', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        if ($live) {
            $classId = (int) $live['class_id'];

            $candidates[] = [
                'time' => (string) $live['created_at'],
                'item' => [
                    'title'     => $live['name'],
                    'thumbnail' => $live['thumbnail'],
                    'progress'  => $this->classProgress($db, $classId, $userId)['percent'],
                    'url'       => '/bootcamp/classes/' . $classId . '/intro',
                ],
            ];
        }

        if (! $candidates) {
            return null;
        }

        usort($candidates, static fn ($a, $b) => strcmp($b['time'], $a['time']));

        return $candidates[0]['item'];
    }

    /**
     * Progres user dalam satu kelas bootcamp: resource wajib selesai / total resource wajib.
     */
    private function classProgress($db, int $classId, int $userId): array
    {
        $cmIds = array_column(
            $db->table('cls_class_materials')
                ->select('id')
                ->where('class_id', $classId)
                ->get()
                ->getResultArray(),
            'id'
        );

        if (! $cmIds) {
            return ['percent' => 0, 'completed' => 0, 'total' => 0];
        }

        $required = $db->table('cls_learning_resources r')
            ->join('cls_class_materials cm', 'cm.material_id = r.material_id')
            ->whereIn('cm.id', $cmIds)
            ->where('r.is_required', 1)
            ->where('r.deleted_at IS NULL')
            ->countAllResults();

        // Hanya resource WAJIB yang selesai (konsisten dgn halaman belajar)
        $completed = $db->table('cls_learning_resources r')
            ->join('cls_class_materials cm', 'cm.material_id = r.material_id')
            ->join('cls_learning_progress p', 'p.resource_id = r.id AND p.class_material_id = cm.id AND p.user_id = ' . $userId)
            ->whereIn('cm.id', $cmIds)
            ->where('r.is_required', 1)
            ->where('r.deleted_at IS NULL')
            ->where('p.status', 'completed')
            ->countAllResults();

        return [
            'percent'   => $required > 0 ? (int) round(($completed / $required) * 100) : 0,
            'completed' => (int) $completed,
            'total'     => (int) $required,
        ];
    }
}
