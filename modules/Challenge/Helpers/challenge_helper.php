<?php

/**
 * Challenge Helper Functions
 */

if (!function_exists('format_team_members')) {
    /**
     * Format team members JSON to HTML list
     */
    function format_team_members($json)
    {
        if (empty($json)) {
            return '-';
        }

        $members = json_decode($json, true);
        
        if (!is_array($members) || empty($members)) {
            return '-';
        }

        $html = '<ul class="list-unstyled mb-0">';
        foreach ($members as $member) {
            $role = $member['role'] ?? 'Member';
            $html .= '<li>';
            $html .= '<strong>' . esc($member['name']) . '</strong>';
            $html .= ' (' . esc($member['email']) . ')';
            $html .= ' - <span class="badge bg-secondary">' . esc($role) . '</span>';
            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }
}

if (!function_exists('challenge_status_badge')) {
    /**
     * Generate status badge HTML
     */
    function challenge_status_badge($status)
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'validated' => '<span class="badge bg-info">Validated</span>',
            'approved' => '<span class="badge bg-success">Approved</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
        ];

        return $badges[$status] ?? '<span class="badge bg-secondary">' . esc($status) . '</span>';
    }
}

if (!function_exists('challenge_file_icon')) {
    /**
     * Get file icon based on extension
     */
    function challenge_file_icon($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $icons = [
            'pdf' => 'bi-file-pdf',
            'txt' => 'bi-file-text',
            'json' => 'bi-file-code',
            'jpg' => 'bi-file-image',
            'jpeg' => 'bi-file-image',
            'png' => 'bi-file-image',
        ];

        return $icons[$extension] ?? 'bi-file-earmark';
    }
}

if (!function_exists('challenge_upload_path')) {
    /**
     * Get upload path for user
     */
    function challenge_upload_path($userId)
    {
        return WRITEPATH . 'uploads/challenge/' . $userId . '/';
    }
}

if (!function_exists('ensure_upload_directory')) {
    /**
     * Ensure upload directory exists
     */
    function ensure_upload_directory($userId)
    {
        $path = challenge_upload_path($userId);
        
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    }

    if (!function_exists('profile_upload_path')) {
        function profile_upload_path($userId)
        {
            return WRITEPATH . 'uploads/profile/' . $userId . '/';
        }
    }

    if (!function_exists('ensure_profile_upload_directory')) {
        function ensure_profile_upload_directory($userId)
        {
            $path = profile_upload_path($userId);
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            return $path;
        }
    }
}
