<?php

namespace App\Pages\kelas;

use App\Pages\BaseController;

/**
 * Halaman "Kelas Saya" — daftar seluruh kelas milik user yang login:
 * Live class (bootcamp, tabel cls_*) dan Online course (tabel courses).
 * Plus daftar kelas yang bisa diikuti (belum terdaftar di course_students / cls_class_members).
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

        // ===== Bootcamp yang sedang berlangsung (yang saya ikuti) =====
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

        // Jumlah pertemuan per kelas (satu query)
        $materialCounts = [];
        $matRows        = $db->table('cls_class_materials')
            ->select('class_id, COUNT(*) AS total')
            ->groupBy('class_id')
            ->get()
            ->getResultArray();
        foreach ($matRows as $matRow) {
            $materialCounts[(int) $matRow['class_id']] = (int) $matRow['total'];
        }

        $myBootcamps = [];
        foreach ($liveRows as $cls) {
            $classId = (int) $cls['id'];

            $myBootcamps[] = [
                'id'              => $classId,
                'course_title'    => $cls['name'],
                'thumbnail'       => $cls['thumbnail'],
                // Batch diambil dari akhiran nama, mis. "Bootcamp Vibe Coding — Batch 1"
                'batch_name'      => preg_match('/[—–-]\s*(.+)$/u', (string) $cls['name'], $m) ? trim($m[1]) : null,
                'syllabus_name'   => $cls['syllabus_name'],
                'total_materials' => $materialCounts[$classId] ?? 0,
                'url'             => '/bootcamp/classes/' . $classId . '/intro',
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
                'course_title'    => $course['course_title'],
                'thumbnail'       => $course['thumbnail'] ?: $course['cover'],
                'total_module'    => $total,
                'total_completed' => $done,
                // Persentase dihitung dari modul wajib agar konsisten dgn angka di atasnya
                'progress'        => $total > 0
                    ? (int) round(($done / $total) * 100)
                    : (int) $course['progress'],
                'url'             => '/courses/intro/' . $courseId . '/' . ($course['slug'] ?? ''),
            ];
        }

        $this->data['my_bootcamps'] = $myBootcamps;
        $this->data['my_courses']   = $onlineCourses;

        // ===== Kelas yang bisa diikuti (belum terdaftar) =====
        $this->data['available_bootcamps'] = $this->availableBootcamps($db, $userId);
        $this->data['available_courses']   = $this->availableCourses($db, $userId);

        return $this->respondSecure($this->data);
    }

    /**
     * Bootcamp yang bisa diikuti: kelas aktif yang belum diikuti user (cls_class_members).
     */
    private function availableBootcamps($db, int $userId): array
    {
        $enrolledClassIds = array_column(
            $db->table('cls_class_members')
                ->select('class_id')
                ->where('user_id', $userId)
                ->where('status', 'active')
                ->get()
                ->getResultArray(),
            'class_id'
        );

        $builder = $db->table('cls_classes c')
            ->select('c.id, c.name, c.thumbnail, c.description, c.start_date, s.name AS syllabus_name')
            ->join('cls_syllabuses s', 's.id = c.syllabus_id', 'left')
            ->where('c.status', 'active')
            ->where('c.deleted_at IS NULL')
            ->orderBy('c.start_date', 'DESC');

        if ($enrolledClassIds) {
            $builder->whereNotIn('c.id', $enrolledClassIds);
        }

        // Jumlah pertemuan per kelas (satu query)
        $materialCounts = [];
        $matRows        = $db->table('cls_class_materials')
            ->select('class_id, COUNT(*) AS total')
            ->groupBy('class_id')
            ->get()
            ->getResultArray();
        foreach ($matRows as $matRow) {
            $materialCounts[(int) $matRow['class_id']] = (int) $matRow['total'];
        }

        $bootcamps = [];
        foreach ($builder->get()->getResultArray() as $row) {
            $classId = (int) $row['id'];

            $bootcamps[] = [
                'id'              => $classId,
                'title'           => $row['name'],
                'thumbnail'       => $row['thumbnail'],
                'description'     => $row['description'],
                'syllabus_name'   => $row['syllabus_name'],
                'start_date'      => $row['start_date'],
                'total_materials' => $materialCounts[$classId] ?? 0,
            ];
        }

        return $bootcamps;
    }

    /**
     * Online course yang bisa diikuti: status published & belum terdaftar di course_students.
     * Kelas beasiswa (id 1) tidak diikutkan karena dibuka lewat /beasiswa.
     */
    private function availableCourses($db, int $userId): array
    {
        $enrolledCourseIds = array_column(
            $db->table('course_students')
                ->select('course_id')
                ->where('user_id', $userId)
                ->get()
                ->getResultArray(),
            'course_id'
        );

        $builder = $db->table('courses')
            ->select('id, course_title, slug, cover, thumbnail, description, total_module')
            ->where('status', 'published')
            ->where('deleted_at', null)
            ->where('id !=', 1)
            ->orderBy('course_order', 'ASC')
            ->orderBy('id', 'ASC');

        if ($enrolledCourseIds) {
            $builder->whereNotIn('id', $enrolledCourseIds);
        }

        $courses = [];
        foreach ($builder->get()->getResultArray() as $course) {
            $courses[] = [
                'id'           => (int) $course['id'],
                'course_title' => $course['course_title'],
                'thumbnail'    => $course['thumbnail'] ?: $course['cover'],
                'description'  => $course['description'],
                'total_module' => (int) $course['total_module'],
                'url'          => '/courses/intro/' . $course['id'] . '/' . ($course['slug'] ?? ''),
            ];
        }

        return $courses;
    }
}
