<?php namespace App\Pages\zpanel\course\student;

use App\Controllers\BaseController;

class PageController extends BaseController 
{
    public function getIndex()
    {
        $data['page_title'] = "Course Student";

        $students = new \App\Models\ScholarshipParticipantModel();
        
        // Base query with joins and subqueries
        $students->select('scholarship_participants.id, scholarship_participants.fullname, scholarship_participants.whatsapp, scholarship_participants.program, scholarship_participants.created_at, users.last_active, (SELECT course_lessons.lesson_title FROM course_lesson_progress clp JOIN course_lessons ON course_lessons.id = clp.lesson_id WHERE clp.user_id = users.id ORDER BY clp.id DESC LIMIT 1) as lesson_title, (SELECT clp.created_at FROM course_lesson_progress clp WHERE clp.user_id = users.id ORDER BY clp.id DESC LIMIT 1) as last_progress_at');
        $students->join('users', 'users.id = scholarship_participants.user_id');

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
        }

        // Order and paginate
        $students->orderBy('scholarship_participants.id', 'DESC');
        $data['students'] = $students->asObject()->paginate(10);
        $data['pager'] = $students->pager;

        // Pass filter values to view
        $data['filter'] = $filter;

        return pageView('zpanel/course/student/index', $data);
    }
}
