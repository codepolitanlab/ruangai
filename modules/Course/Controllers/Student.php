<?php

namespace Course\Controllers;

use Heroicadmin\Controllers\AdminController;

class Student extends AdminController
{
    public $data = [
        'page_title' => 'Course Student',
        'module'     => 'elearning',
        'submodule'  => 'course',
    ];

    public function index($course_id = null)
    {
        $students = new \Course\Models\CourseStudentModel();
        $db       = \Config\Database::connect();

        // course_students bisa punya baris duplikat per user → pakai baris terbaru saja.
        // Dedupe lewat subquery MAX(id); GROUP BY user_id + SELECT course_students.* tidak valid
        // saat ONLY_FULL_GROUP_BY aktif (error 1055).
        $latestIds = $db->table('course_students')
            ->select('MAX(id) AS id')
            ->where('course_id', $course_id)
            ->groupBy('user_id');

        // Base query with joins and subqueries
        $students->select('course_students.*, users.name, users.email, users.last_active, users.phone');
        $students->join('(' . $latestIds->getCompiledSelect() . ') latest', 'latest.id = course_students.id');
        $students->join('users', 'users.id = course_students.user_id');
        $students->where('course_students.course_id', $course_id);

        // Apply filters
        $filter = $this->request->getGet('filter');
        if (! empty($filter)) {
            if (! empty($filter['name'])) {
                $students->like('users.name', $filter['name']);
            }
            if (! empty($filter['email'])) {
                $students->like('users.email', $filter['email']);
            }
            if (! empty($filter['phone'])) {
                $students->like('users.phone', $filter['phone']);
            }
            if (! empty($filter['progress'])) {
                $students->like('course_students.progress', $filter['progress']);
            }
            if (! empty($filter['created_at'])) {
                $students->like('course_students.created_at', $filter['created_at']);
            }

            // Handle sorting
            if (! empty($filter['field']) && ! empty($filter['order'])) {
                $orderField = match ($filter['field']) {
                    'name'            => 'users.name',
                    'email'           => 'users.email',
                    'phone'           => 'users.phone',
                    'progress'        => 'course_students.progress',
                    'progress_update' => 'course_students.progress_update',
                    default           => 'course_students.created_at'
                };
                $students->orderBy($orderField, $filter['order']);
            } else {
                $students->orderBy('course_students.created_at', 'desc');
            }
        } else {
            $students->orderBy('course_students.created_at', 'desc');
        }

        // Get perpage value from request, default to 10
        $perpage = (int) $this->request->getGet('perpage') ?: 10;

        // Paginate results
        $data['students'] = $students->asObject()->paginate($perpage);
        $data['pager']    = $students->pager;

        $data['total_student'] = count($data['students']);

        // Pass filter values and perpage to view
        $data['filter']  = $filter;
        $data['perpage'] = $perpage;
        $data['course']  = model('Course')->asObject()->find($course_id);

        $this->data = array_merge($this->data, $data);

        return pageView('Course\Views\student\index', $this->data);
    }
}
