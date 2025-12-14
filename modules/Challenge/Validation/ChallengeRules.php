<?php

namespace Challenge\Validation;

class ChallengeRules
{
    /**
     * Validate Twitter/X post URL format
     */
    public function twitter_url_format(string $str, string &$error = ''): bool
    {
        $pattern = '/^https?:\/\/(www\.)?(twitter\.com|x\.com)\/[a-zA-Z0-9_]+\/status\/[0-9]+/';
        
        if (!preg_match($pattern, $str)) {
            $error = 'URL post Twitter/X tidak valid. Format: https://twitter.com/username/status/123456 atau https://x.com/username/status/123456';
            return false;
        }

        return true;
    }

    /**
     * Validate team members JSON structure
     */
    public function team_members_json(string $str, string &$error = ''): bool
    {
        $members = json_decode($str, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'Format team members tidak valid (harus JSON)';
            return false;
        }

        if (!is_array($members)) {
            $error = 'Team members harus berupa array';
            return false;
        }

        if (count($members) > 3) {
            $error = 'Maksimal 3 anggota tim';
            return false;
        }

        if (count($members) < 1) {
            $error = 'Minimal 1 anggota tim (diri sendiri)';
            return false;
        }

        // Validate each member structure
        foreach ($members as $member) {
            if (!isset($member['name']) || empty(trim($member['name']))) {
                $error = 'Setiap anggota tim harus memiliki nama';
                return false;
            }

            if (!isset($member['email']) || !filter_var($member['email'], FILTER_VALIDATE_EMAIL)) {
                $error = 'Email anggota tim tidak valid';
                return false;
            }
        }

        // Check for duplicate emails
        $emails = array_column($members, 'email');
        if (count($emails) !== count(array_unique($emails))) {
            $error = 'Email anggota tim tidak boleh duplikat';
            return false;
        }

        return true;
    }

    /**
     * Validate JSON params file structure
     */
    public function json_params_structure(string $filePath, string &$error = ''): bool
    {
        if (!file_exists($filePath)) {
            $error = 'File params tidak ditemukan';
            return false;
        }

        $content = file_get_contents($filePath);
        $params = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = 'Format JSON params tidak valid';
            return false;
        }

        // Check required keys
        $requiredKeys = ['model', 'version'];
        foreach ($requiredKeys as $key) {
            if (!isset($params[$key]) || empty($params[$key])) {
                $error = "Field '{$key}' wajib ada dalam file params.json";
                return false;
            }
        }

        // Validate model contains 'wan'
        if (stripos($params['model'], 'wan') === false) {
            $error = 'Model harus menggunakan WAN (Alibaba Model Studio)';
            return false;
        }

        return true;
    }

    /**
     * Check if user already has active submission
     */
    public function one_submission_per_user(string $userId, string $field, array $data, string &$error = null): bool
    {
        $model = new \Challenge\Models\ChallengeAlibabaModel();
        
        if ($model->hasActiveSubmission($userId)) {
            $error = 'Anda sudah memiliki submission aktif. Satu akun hanya boleh submit satu kali.';
            return false;
        }

        return true;
    }

    /**
     * Validate file extension is PDF or TXT
     */
    public function file_extension_pdf_or_txt(string $fileName, string &$error = ''): bool
    {
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($extension, ['pdf', 'txt'])) {
            $error = 'File harus berformat PDF atau TXT';
            return false;
        }

        return true;
    }

    /**
     * Validate file is image (for screenshots)
     */
    public function file_is_image(string $fileName, string &$error = ''): bool
    {
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $error = 'File harus berformat JPG, JPEG, atau PNG';
            return false;
        }

        return true;
    }
}
