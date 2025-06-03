<?php namespace App\Pages\zpanel\course\student;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course Student";

        $students = new \App\Models\ScholarshipParticipantModel();
        
        // Base query with joins and subqueries
        $students->select('scholarship_participants.id, scholarship_participants.fullname, scholarship_participants.whatsapp, scholarship_participants.program, scholarship_participants.created_at, users.last_active, course_students.progress, course_students.updated_at as last_progress_at');
        $students->join('users', 'users.id = scholarship_participants.user_id');
        $students->join('course_students', 'course_students.user_id = users.id', 'left');

        // Apply filters
        $filter = $this->request->getGet('filter');
        if (!empty($filter)) {
            if (!empty($filter['fullname'])) {
                $students->like('scholarship_participants.fullname', $filter['fullname']);
            }
            if (!empty($filter['program'])) {
                $students->like('scholarship_participants.program', $filter['program']);
            }
            if (!empty($filter['whatsapp'])) {
                $students->like('scholarship_participants.whatsapp', $filter['whatsapp']);
            }
            if (!empty($filter['progress'])) {
                $students->like('course_students.progress', $filter['progress']);
            }
            if (!empty($filter['created_at'])) {
                $students->like('scholarship_participants.created_at', $filter['created_at']);
            }
            if (!empty($filter['order'])) {
                $students->orderBy('scholarship_participants.created_at', $filter['order']);
            }
        }

        // Order and paginate
        $students->orderBy('scholarship_participants.id', 'DESC');
        $data['students'] = $students->asObject()->paginate(10);
        $data['pager'] = $students->pager;
        $data['programs'] = model('Events')->findAll();

        // Pass filter values to view
        $data['filter'] = $filter;

        return pageView('zpanel/course/student/index', $data);
    }
}
