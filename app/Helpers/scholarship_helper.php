<?php

/**
 * Scholarship Helper
 * 
 * Helper functions untuk menangani logic terkait beasiswa
 * dan membedakan user beasiswa vs user kompetisi
 */

if (!function_exists('is_scholarship_participant')) {
    /**
     * Check apakah user adalah peserta beasiswa
     * 
     * @param int $user_id
     * @return bool
     */
    function is_scholarship_participant($user_id)
    {
        $db = \Config\Database::connect();
        
        $participant = $db->table('scholarship_participants')
            ->where('user_id', $user_id)
            ->where('deleted_at', null)
            ->countAllResults();
            
        return $participant > 0;
    }
}

if (!function_exists('get_scholarship_data')) {
    /**
     * Get data beasiswa user dengan safe null handling
     * 
     * @param int $user_id
     * @return object|null
     */
    function get_scholarship_data($user_id)
    {
        $db = \Config\Database::connect();
        
        $data = $db->table('scholarship_participants')
            ->where('user_id', $user_id)
            ->where('deleted_at', null)
            ->get()
            ->getRow();
            
        return $data;
    }
}

if (!function_exists('is_enrolled_in_course')) {
    /**
     * Check apakah user terdaftar di course tertentu
     * 
     * @param int $user_id
     * @param int $course_id
     * @return bool
     */
    function is_enrolled_in_course($user_id, $course_id)
    {
        $db = \Config\Database::connect();
        
        $enrolled = $db->table('course_students')
            ->where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->countAllResults();
            
        return $enrolled > 0;
    }
}

if (!function_exists('get_student_course_data')) {
    /**
     * Get data course student dengan safe null handling
     * 
     * @param int $user_id
     * @param int $course_id
     * @return object|null
     */
    function get_student_course_data($user_id, $course_id)
    {
        $db = \Config\Database::connect();
        
        $data = $db->table('course_students')
            ->select('course_students.*, scholarship_participants.program, scholarship_participants.reference')
            ->join('scholarship_participants', 'scholarship_participants.user_id = course_students.user_id', 'left')
            ->where('course_students.user_id', $user_id)
            ->where('course_students.course_id', $course_id)
            ->get()
            ->getRow();
            
        return $data;
    }
}

if (!function_exists('scholarship_registration_url')) {
    /**
     * Get URL untuk pendaftaran beasiswa
     * 
     * @return string
     */
    function scholarship_registration_url()
    {
        return 'https://ruangai.id';
    }
}
