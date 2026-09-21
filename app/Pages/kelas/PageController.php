<?php

namespace App\Pages\kelas;

use App\Pages\BaseController;

/**
 * Halaman "Kelas Saya" — daftar seluruh kelas milik user yang login:
 * Live class (bootcamp, tabel cls_*) dan Online course (tabel courses).
 */
class PageController extends BaseController
{
    public $data = [
        'page_title'  => 'Kelas Saya',
        'module'      => 'kelas',
        'active_page' => 'kelas',
        'body_class'  => 'rd-dashboard-page',
    ];

    /**
     * GET /kelas/data
     */
    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        $this->data['user'] = [
            'name'  => $jwt->user['name'] ?? '',
            'email' => $jwt->user['email'] ?? '',
        ];

        // ===== Live class (bootcamp) =====
        $liveRows = $db->table('cls_classes c')
            ->select('c.id, c.name, c.thumbnail, c.description, c.start_date, cm.enrolled_at, s.name AS syllabus_name')
            ->join('cls_class_members cm', 'cm.class_id = c.id AND cm.user_id = ' . $userId)
            ->join('cls_syllabuses s', 's.id = c.syllabus_id', 'left')
            ->where('cm.status', 'active')
            ->where('c.status', 'active')
            ->where('c.deleted_at IS NULL')
            ->orderBy('c.start_date', 'DESC')
            ->get()
            ->getResultArray();

        $liveClasses = [];
        foreach ($liveRows as $cls) {
            $classId  = (int) $cls['id'];
            $progress = $this->classProgress($db, $classId, $userId);

            $liveClasses[] = [
                'id'              => $classId,
                'is_live'         => true,
                'course_title'    => $cls['name'],
                'thumbnail'       => $cls['thumbnail'],
                // Batch diambil dari akhiran nama, mis. "Bootcamp Vibe Coding — Batch 1"
                'batch_name'      => preg_match('/[—–-]\s*(.+)$/u', (string) $cls['name'], $m) ? trim($m[1]) : null,
                'total_materials' => (int) $db->table('cls_class_materials')
                    ->where('class_id', $classId)
                    ->countAllResults(),
                'total_module'    => 0,
                'total_completed' => $progress['completed'],
                'progress'        => $progress['percent'],
                'url'             => '/bootcamp/classes/' . $classId . '/intro',
                'last_time'       => $cls['enrolled_at'],
            ];
        }

        // ===== Online course =====
        $onlineRows = $db->table('course_students')
            ->select('courses.id, courses.course_title, courses.slug, courses.cover, courses.thumbnail, courses.description, courses.total_module, course_students.progress, course_students.created_at')
            ->join('courses', 'courses.id = course_students.course_id')
            ->where('course_students.user_id', $userId)
            ->where('course_students.deleted_at', null)
            ->orderBy('course_students.created_at', 'ASC')
            ->get()
            ->getResultArray();

        // Total modul wajib & modul wajib yang sudah selesai per course (satu query)
        $moduleStats = [];
        $statsRows   = $db->table('course_lessons cl')
            ->select('cl.course_id, COUNT(DISTINCT cl.id) AS total, COUNT(DISTINCT clp.id) AS completed')
            ->join('course_lesson_progress clp', 'clp.lesson_id = cl.id AND clp.user_id = ' . $userId, 'left')
            ->where('cl.mandatory', 1)
            ->groupBy('cl.course_id')
            ->get()
            ->getResultArray();

        foreach ($statsRows as $stat) {
            $moduleStats[(int) $stat['course_id']] = [
                'total'     => (int) $stat['total'],
                'completed' => (int) $stat['completed'],
            ];
        }

        $onlineCourses = [];
        foreach ($onlineRows as $course) {
            $courseId = (int) $course['id'];
            $stat     = $moduleStats[$courseId] ?? ['total' => 0, 'completed' => 0];
            $total    = $stat['total'];
            $done     = $stat['completed'];

            $onlineCourses[] = [
                'id'              => $courseId,
                'is_live'         => false,
                'course_title'    => $course['course_title'],
                'thumbnail'       => $course['thumbnail'] ?: $course['cover'],
                'batch_name'      => null,
                'total_materials' => 0,
                'total_module'    => $total,
                'total_completed' => $done,
                // Persentase dihitung dari modul wajib agar konsisten dgn angka di atasnya
                'progress'        => $total > 0
                    ? (int) round(($done / $total) * 100)
                    : (int) $course['progress'],
                'url'             => '/courses/intro/' . $courseId . '/' . ($course['slug'] ?? ''),
                'last_time'       => $course['created_at'],
            ];
        }

        // Live class tampil lebih dulu, lalu online course
        $this->data['my_courses']  = array_merge($liveClasses, $onlineCourses);
        $this->data['last_course'] = $this->lastStudied($db, $userId, $this->data['my_courses']);

        return $this->respondSecure($this->data);
    }

    /**
     * Kelas yang terakhir dipelajari user (dari progres online course & live class).
     */
    private function lastStudied($db, int $userId, array $courses): ?array
    {
        if (! $courses) {
            return null;
        }

        $byKey = [];
        foreach ($courses as $course) {
            $byKey[($course['is_live'] ? 'live-' : 'online-') . $course['id']] = $course;
        }

        $candidates = [];

        // Online course → lesson terakhir yang dibuka
        $onlineLast = $db->table('course_lesson_progress')
            ->select('course_id, created_at')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        if ($onlineLast && isset($byKey['online-' . (int) $onlineLast['course_id']])) {
            $candidates[] = [
                'time'   => (string) $onlineLast['created_at'],
                'course' => $byKey['online-' . (int) $onlineLast['course_id']],
            ];
        }

        // Live class → resource terakhir yang dikerjakan
        $liveLast = $db->table('cls_learning_progress p')
            ->select('cm.class_id, p.created_at')
            ->join('cls_class_materials cm', 'cm.id = p.class_material_id')
            ->where('p.user_id', $userId)
            ->orderBy('p.created_at', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        if ($liveLast && isset($byKey['live-' . (int) $liveLast['class_id']])) {
            $candidates[] = [
                'time'   => (string) $liveLast['created_at'],
                'course' => $byKey['live-' . (int) $liveLast['class_id']],
            ];
        }

        if ($candidates) {
            usort($candidates, static fn ($a, $b) => strcmp($b['time'], $a['time']));

            return $candidates[0]['course'];
        }

        // Belum ada progres → tampilkan kelas pertama
        return $courses[0];
    }

    /**
     * Progres user dalam satu kelas: completed resource wajib / total resource wajib.
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
