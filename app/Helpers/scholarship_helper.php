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
     * Get URL untuk pendaftaran beasiswa dengan JWT token
     * 
     * @param int $user_id
     * @return string
     */
    function scholarship_registration_url($user_id)
    {
        $db = \Config\Database::connect();
        
        // Check if user is scholarship participant
        $isScholarshipParticipant = is_scholarship_participant($user_id);
        
        // Get user data from users table
        $userData = $db->table('users')
            ->select('name, email, phone')
            ->where('id', $user_id)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();
        
        // Get user profile data
        $profileData = $db->table('user_profiles')
            ->where('user_id', $user_id)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        // Inject name, email, phone into profile data for easier access
        if ($profileData) {
            $profileData['fullname']  = $userData['name'] ?? '';
            $profileData['email'] = $userData['email'] ?? '';
            $profileData['whatsapp_number'] = $userData['phone'] ?? '';
        }
        
        // Check if profile is complete
        $isProfileComplete = false;
        if ($userData && $profileData) {
            $isProfileComplete = 
                !empty($userData['name']) &&
                !empty($userData['email']) &&
                !empty($userData['phone']) &&
                !empty($profileData['birthday']) &&
                !empty($profileData['gender']) &&
                !empty($profileData['province']) &&
                !empty($profileData['city']) &&
                !empty($profileData['occupation']);
        }
        
        // Prepare token payload
        $tokenPayload = [
            'user_id' => $user_id,
            'participant' => $userData['name'] ?? '',
            'is_scholarship_participant' => $isScholarshipParticipant,
            'is_profile_complete' => $isProfileComplete,
            'profile' => $profileData ?? [],
            'exp' => time() + (60 * 60 * 24) // 24 hours expiration
        ];
        
        // Generate JWT token
        $token = \Firebase\JWT\JWT::encode(
            $tokenPayload,
            config('Heroic')->jwtKey['secret'],
            'HS256'
        );
        
        // Debug: verify token format
        $segmentCount = substr_count($token, '.');
        log_message('debug', 'Generated token segments: ' . $segmentCount . ', Token length: ' . strlen($token));
        
        if ($segmentCount !== 2) {
            log_message('error', 'Invalid JWT generated! Token preview: ' . substr($token, 0, 100));
        }
        
        // Determine base URL based on environment
        $baseUrl = 'https://ruangai.id/registration';
        
        return $baseUrl . '?token=' . $token;
    }
}
