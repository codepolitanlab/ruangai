<?php

namespace Challenge\Controllers;

use Heroicadmin\Controllers\AdminController;
use App\Models\UserModel;
use App\Models\UserProfile;
use App\Models\UserToken;
use Challenge\Models\ChallengeAlibabaModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Importer extends AdminController
{
    protected $userModel;
    protected $userProfileModel;
    protected $challengeModel;
    protected $userTokenModel;
    protected $db;

    public function __construct()
    {
        $this->data['page_title'] = 'Challenge Importer';
        $this->data['module']     = 'challenge';
        $this->data['submodule']  = 'importer';

        $this->userModel        = new UserModel();
        $this->userProfileModel = new UserProfile();
        $this->challengeModel   = new ChallengeAlibabaModel();
        $this->userTokenModel   = new UserToken();
        $this->db               = \Config\Database::connect();
    }

    /**
     * Display upload form
     */
    public function index()
    {
        return view('Challenge\Views\importer\index', $this->data);
    }

    /**
     * Process CSV import
     */
    public function process()
    {
        set_time_limit(0); // Set unlimited execution time for large imports
        $validationRule = [
            'csv_file' => [
                'label' => 'CSV File',
                'rules' => 'uploaded[csv_file]|ext_in[csv_file,csv]|max_size[csv_file,10240]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $file = $this->request->getFile('csv_file');
        
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File upload gagal: ' . $file->getErrorString());
        }

        // Parse CSV
        $csvData = $this->parseCSV($file);
        
        if (empty($csvData)) {
            return redirect()->back()->with('error', 'File CSV kosong atau format tidak valid');
        }

        // Process import
        $result = $this->importData($csvData);

        // Prepare result message
        $message = sprintf(
            'Import selesai!<br>Users baru: %d<br>Users existing: %d<br>Gagal: %d',
            $result['imported_users'],
            $result['existing_users'],
            $result['failed_rows']
        );

        if (!empty($result['errors'])) {
            $message .= '<br><br>Detail Error:<br>' . implode('<br>', array_slice($result['errors'], 0, 10));
            if (count($result['errors']) > 10) {
                $message .= '<br>... dan ' . (count($result['errors']) - 10) . ' error lainnya';
            }
        }

        return redirect()->back()->with($result['failed_rows'] > 0 ? 'warning' : 'success', $message);
    }

    /**
     * Parse CSV file
     */
    private function parseCSV($file)
    {
        $csvData = [];
        $handle = fopen($file->getTempName(), 'r');
        
        if ($handle === false) {
            return [];
        }

        // Read header
        $header = fgetcsv($handle);
        
        if ($header === false) {
            fclose($handle);
            return [];
        }

        // Read data rows
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === count($header)) {
                $csvData[] = array_combine($header, $row);
            }
        }

        fclose($handle);
        return $csvData;
    }

    /**
     * Import data from CSV
     */
    private function importData(array $csvData)
    {
        // Set timeout 0
        set_time_limit(0);
        $stats = [
            'imported_users' => 0,
            'existing_users' => 0,
            'failed_rows'    => 0,
            'errors'         => [],
        ];

        foreach ($csvData as $index => $row) {
            $rowNumber = $index + 2; // +2 karena: +1 untuk header, +1 untuk 1-indexed
            
            try {
                // Start transaction for each row
                $this->db->transStart();

                $result = $this->processRow($row);
                
                if ($result['is_new_user']) {
                    $stats['imported_users']++;
                } else {
                    $stats['existing_users']++;
                }

                $this->db->transComplete();

                if ($this->db->transStatus() === false) {
                    throw new \Exception('Transaction failed');
                }

            } catch (\Exception $e) {
                $stats['failed_rows']++;
                $stats['errors'][] = "Baris {$rowNumber} ({$row['email']}): " . $e->getMessage();
                
                // Rollback jika transaction gagal
                if ($this->db->transStatus() === false) {
                    $this->db->transRollback();
                }

                // Log error
                log_message('error', "CSV Import Error - Row {$rowNumber}: " . $e->getMessage());
            }
        }

        // Log summary
        log_message('info', sprintf(
            'CSV Import Summary - Imported: %d, Existing: %d, Failed: %d',
            $stats['imported_users'],
            $stats['existing_users'],
            $stats['failed_rows']
        ));

        return $stats;
    }

    /**
     * Process single row from CSV
     */
    private function processRow(array $row)
    {
        $email = trim($row['email'] ?? '');
        
        if (empty($email)) {
            throw new \Exception('Email kosong');
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Format email tidak valid');
        }

        // 1. Check or create user
        $user = $this->userModel
            ->where('email', $email)
            ->where('deleted_at', null)
            ->first();

        $isNewUser = false;

        if (!$user) {
            // Create new user
            $Phpass   = new \App\Libraries\Phpass();
            $userData = [
                'name'       => trim($row['fullname'] ?? ''),
                'email'      => $email,
                'phone'      => $this->cleanPhone($row['whatsapp'] ?? ''),
                'pwd'        => $Phpass->HashPassword('BelajarAI@2026'),
                'role_id'    => 2, // Default role untuk user biasa
                'source'     => trim($row['source'] ?? 'csv_import'),
                'created_at' => $row['created_at'] ?? date('Y-m-d H:i:s'),
                'updated_at' => $row['updated_at'] ?? date('Y-m-d H:i:s'),
            ];

            $userId = $this->userModel->insert($userData);
            
            if (!$userId) {
                throw new \Exception('Gagal membuat user baru');
            }

            $isNewUser = true;
        } else {
            $userId = $user['id'];
        }

        // 2. Insert or update user_profiles
        $this->upsertUserProfile($userId, $row);

        // 3. Insert challenge_alibaba
        $this->insertChallengeParticipation($userId, $row);

        // 4. Insert scholarship_participants (konversi user GenAI ke beasiswa)
        $this->insertScholarshipParticipant($userId, $row);

        // 5. Enroll to course_students with course_id = 1
        $this->enrollCourseStudent($userId);

        return ['is_new_user' => $isNewUser];
    }

    /**
     * Insert or update user profile
     */
    private function upsertUserProfile($userId, array $row)
    {
        // Konversi province dan city ID ke name
        $provinceName = $this->getProvinceName($row['province'] ?? '');
        $cityName = $this->getRegencyName($row['city'] ?? '');

        $profileData = [
            'user_id'           => $userId,
            'birthday'          => $this->formatDate($row['birthday'] ?? ''),
            'gender'            => trim($row['gender'] ?? ''),
            'province'          => $provinceName,
            'city'              => $cityName,
            'occupation'        => trim($row['occupation'] ?? ''),
            'work_experience'   => trim($row['work_experience'] ?? ''),
            'skill'             => trim($row['skill'] ?? ''),
            'institution'       => trim($row['institution'] ?? ''),
            'major'             => trim($row['major'] ?? ''),
            'semester'          => trim($row['semester'] ?? ''),
            'grade'             => trim($row['grade'] ?? ''),
            'type_of_business'  => trim($row['type_of_business'] ?? ''),
            'business_duration' => trim($row['business_duration'] ?? ''),
            'education_level'   => trim($row['education_level'] ?? ''),
            'graduation_year'   => trim($row['graduation_year'] ?? ''),
            'link_business'     => trim($row['link_business'] ?? ''),
            'last_project'      => trim($row['last_project'] ?? ''),
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        // Check if profile exists
        $existingProfile = $this->userProfileModel
            ->where('user_id', $userId)
            ->first();

        if ($existingProfile) {
            // Update existing profile
            $this->userProfileModel->update($existingProfile['id'], $profileData);
        } else {
            // Insert new profile
            $profileData['created_at'] = date('Y-m-d H:i:s');
            $this->userProfileModel->insert($profileData);
        }
    }

    /**
     * Insert challenge participation (avoid duplicate)
     */
    private function insertChallengeParticipation($userId, array $row)
    {
        // Set challenge_id statis
        $challengeId = 'wan-vision-clash-2025';

        // Check if already registered for this challenge
        $existing = $this->challengeModel
            ->where('user_id', $userId)
            ->where('challenge_id', $challengeId)
            ->where('deleted_at', null)
            ->first();

        if ($existing) {
            // Sudah terdaftar, skip
            return;
        }

        // Insert new participation
        $challengeData = [
            'user_id'     => $userId,
            'challenge_id' => $challengeId,
            'fullname'    => trim($row['fullname'] ?? ''),
            'email'       => trim($row['email'] ?? ''),
            'whatsapp'    => $this->cleanPhone($row['whatsapp'] ?? ''),
            'status'      => 'pending',
            'created_at'  => $row['created_at'] ?? date('Y-m-d H:i:s'),
            'updated_at'  => $row['updated_at'] ?? date('Y-m-d H:i:s'),
        ];

        $this->challengeModel->insert($challengeData);
    }

    /**
     * Insert scholarship participant (konversi GenAI ke beasiswa)
     */
    private function insertScholarshipParticipant($userId, array $row)
    {
        // Check if already registered in scholarship
        $existing = $this->db->table('scholarship_participants')
            ->where('user_id', $userId)
            ->where('deleted_at', null)
            ->countAllResults();

        if ($existing > 0) {
            // Sudah terdaftar di beasiswa, skip
            return;
        }

        // Set program statis untuk scholarship
        $program = 'RuangAI2026WSGenAI';

        // Prepare scholarship data (hanya data spesifik scholarship, tidak duplikasi user_profiles)
        $scholarshipData = [
            'user_id'                           => $userId,
            'program'                           => $program,
            'prev_chapter'                      => trim($row['program'] ?? ''),
            'fullname'                          => trim($row['fullname'] ?? ''),
            'email'                             => trim($row['email'] ?? ''),
            'whatsapp'                          => $this->cleanPhone($row['whatsapp'] ?? ''),
            'reference'                         => strtolower(trim($row['reference'] ?? '')),
            'referral_code'                     => strtoupper(substr(uniqid(), -6)),
            'status'                            => 'terdaftar',
            'accept_terms'                      => 1,
            'accept_agreement'                  => 1,
            'is_participating_other_ai_program' => 0,
            'withdrawal'                        => 0,
            'created_at'                        => $row['created_at'] ?? date('Y-m-d H:i:s'),
            'updated_at'                        => $row['updated_at'] ?? date('Y-m-d H:i:s'),
        ];

        // Insert to scholarship_participants
        $this->db->table('scholarship_participants')->insert($scholarshipData);
    }

    /**
     * Enroll student to course (default: course_id = 1)
     */
    private function enrollCourseStudent($userId, $courseId = 1)
    {
        // Check if already enrolled
        $existing = $this->db->table('course_students')
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->countAllResults();

        if ($existing > 0) {
            // Sudah terdaftar di course, skip
            return;
        }

        // Insert to course_students
        $courseStudentData = [
            'user_id'    => $userId,
            'course_id'  => $courseId,
            'progress'   => 0,
            'graduate'   => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('course_students')->insert($courseStudentData);
    }

    /**
     * Get province name by ID
     */
    private function getProvinceName($provinceId)
    {
        if (empty($provinceId)) {
            return '';
        }

        $province = $this->db->table('reg_provinces')
            ->select('name')
            ->where('id', $provinceId)
            ->get()
            ->getRow();

        return $province ? $province->name : '';
    }

    /**
     * Get regency name by ID
     */
    private function getRegencyName($regencyId)
    {
        if (empty($regencyId)) {
            return '';
        }

        $regency = $this->db->table('reg_regencies')
            ->select('name')
            ->where('id', $regencyId)
            ->get()
            ->getRow();

        return $regency ? $regency->name : '';
    }

    /**
     * Clean and format phone number
     */
    private function cleanPhone($phone)
    {
        // Remove non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Convert 08 to 628
        if (substr($phone, 0, 2) === '08') {
            $phone = '62' . substr($phone, 1);
        }
        
        // Convert 8 to 628 (if starts with 8)
        if (substr($phone, 0, 1) === '8' && substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Format date from CSV
     */
    private function formatDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            $timestamp = strtotime($date);
            if ($timestamp === false) {
                return null;
            }
            return date('Y-m-d', $timestamp);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Parse submitted_at from CSV format DD/MM/YYYY H:i:s to Y-m-d H:i:s
     */
    private function parseSubmittedAt($value)
    {
        $value = trim($value);
        if (empty($value)) {
            return date('Y-m-d H:i:s');
        }

        // Handle DD/MM/YYYY H:i:s format (e.g. 12/03/2026 9:30:27)
        if (preg_match('#^(\d{1,2})/(\d{1,2})/(\d{4})\s+(\d{1,2}:\d{2}:\d{2})$#', $value, $m)) {
            return sprintf('%s-%02d-%02d %s', $m[3], $m[2], $m[1], $m[4]);
        }

        // Fallback: try strtotime
        $timestamp = strtotime($value);
        return $timestamp !== false ? date('Y-m-d H:i:s', $timestamp) : date('Y-m-d H:i:s');
    }

    /**
     * Display submission upload form
     */
    public function submission()
    {
        return view('Challenge\Views\importer\submission', $this->data);
    }

    /**
     * Process submission CSV import
     */
    public function processSubmission()
    {
        $validationRule = [
            'csv_file' => [
                'label' => 'CSV File',
                'rules' => 'uploaded[csv_file]|ext_in[csv_file,csv]|max_size[csv_file,10240]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $file = $this->request->getFile('csv_file');
        
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File upload gagal: ' . $file->getErrorString());
        }

        // Parse CSV
        $csvData = $this->parseCSV($file);
        
        if (empty($csvData)) {
            return redirect()->back()->with('error', 'File CSV kosong atau format tidak valid');
        }

        // Process import
        $result = $this->importSubmissionData($csvData);

        // Prepare result message
        $message = sprintf(
            'Import submission selesai!<br>Updated: %d<br>Not Found: %d<br>Gagal: %d',
            $result['updated'],
            $result['not_found'],
            $result['failed_rows']
        );

        if (!empty($result['errors'])) {
            $message .= '<br><br>Detail Error:<br>' . implode('<br>', array_slice($result['errors'], 0, 10));
            if (count($result['errors']) > 10) {
                $message .= '<br>... dan ' . (count($result['errors']) - 10) . ' error lainnya';
            }
        }

        return redirect()->back()->with($result['failed_rows'] > 0 ? 'warning' : 'success', $message);
    }

    /**
     * Import submission data from CSV
     */
    private function importSubmissionData(array $csvData)
    {
        set_time_limit(0);
        $stats = [
            'updated'     => 0,
            'not_found'   => 0,
            'failed_rows' => 0,
            'errors'      => [],
        ];

        foreach ($csvData as $index => $row) {
            $rowNumber = $index + 2;
            
            try {
                $this->db->transStart();

                $result = $this->processSubmissionRow($row);
                
                if ($result['status'] === 'updated') {
                    $stats['updated']++;
                } elseif ($result['status'] === 'not_found') {
                    $stats['not_found']++;
                }

                $this->db->transComplete();

                if ($this->db->transStatus() === false) {
                    throw new \Exception('Transaction failed');
                }

            } catch (\Exception $e) {
                $stats['failed_rows']++;
                $stats['errors'][] = "Baris {$rowNumber} ({$row['email']}): " . $e->getMessage();
                
                if ($this->db->transStatus() === false) {
                    $this->db->transRollback();
                }

                log_message('error', "Submission Import Error - Row {$rowNumber}: " . $e->getMessage());
            }
        }

        log_message('info', sprintf(
            'Submission Import Summary - Updated: %d, Not Found: %d, Failed: %d',
            $stats['updated'],
            $stats['not_found'],
            $stats['failed_rows']
        ));

        return $stats;
    }

    /**
     * Process single submission row
     */
    private function processSubmissionRow(array $row)
    {
        $email = trim($row['email'] ?? '');
        
        if (empty($email)) {
            throw new \Exception('Email kosong');
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Format email tidak valid');
        }

        // Find participant by email in challenge_alibaba
        $participant = $this->challengeModel
            ->where('email', $email)
            ->where('challenge_id', 'wan-vision-clash-2025')
            ->where('deleted_at', null)
            ->first();

        if (!$participant) {
            return ['status' => 'not_found'];
        }

        $userId = $participant['user_id'];

        // 1. Update user_profiles dengan alibaba_cloud_id dan alibaba_cloud_screenshot
        $alibabaCloudId = trim($row['alibaba_cloud_id'] ?? '');
        $alibabaCloudScreenshot = trim($row['alibaba_cloud_screenshot'] ?? '');
        
        if (!empty($alibabaCloudId) || !empty($alibabaCloudScreenshot)) {
            $profileData = [];
            if (!empty($alibabaCloudId)) {
                $profileData['alibaba_cloud_id'] = $alibabaCloudId;
            }
            if (!empty($alibabaCloudScreenshot)) {
                $profileData['alibaba_cloud_screenshot'] = $alibabaCloudScreenshot;
            }
            $profileData['updated_at'] = date('Y-m-d H:i:s');

            // Check if profile exists
            $existingProfile = $this->userProfileModel->where('user_id', $userId)->first();
            if ($existingProfile) {
                $this->userProfileModel->update($existingProfile['id'], $profileData);
            }
        }

        // 2. Prepare submission data untuk challenge_alibaba
        $submissionData = [
            'twitter_post_url'   => trim($row['twitter_post_url'] ?? ''),
            'video_title'        => trim($row['video_title'] ?? ''),
            'video_description'  => trim($row['video_description'] ?? ''),
            'video_category'     => trim($row['video_category'] ?? ''),
            'other_tools'        => trim($row['other_tools'] ?? ''),
            'updated_at'         => date('Y-m-d H:i:s'),
        ];

        // Update if has submission data
        if (!empty($submissionData['twitter_post_url']) || !empty($submissionData['video_title'])) {
            // Update status to 'review' if has submission
            $submissionData['status'] = 'review';
            $submissionData['submitted_at'] = $this->parseSubmittedAt($row['submitted_at'] ?? '');
            
            $this->challengeModel->update($participant['id'], $submissionData);
            
            // 3. Generate token 'genaivideofest' untuk user yang berhasil
            if (!$this->userTokenModel->isExists($userId, 'genaivideofest')) {
                $this->userTokenModel->generate($userId, 'genaivideofest');
            }
            
            return ['status' => 'updated'];
        }

        return ['status' => 'not_found'];
    }

    /**
     * Download submission CSV template
     */
    public function downloadSubmissionTemplate()
    {
        $csv = implode('\t', [
            'email',
            'alibaba_cloud_id',
            'alibaba_cloud_screenshot',
            'twitter_post_url',
            'video_title',
            'video_category',
            'video_description',
            'other_tools',
            'submitted_at',
        ]) . "\n";

        // Add sample data
        $csv .= implode('\t', [
            'john@example.com',
            'alibaba123456',
            'https://example.com/screenshot.png',
            'https://twitter.com/username/status/123456789',
            'Video Tutorial AI',
            'Tutorial',
            'Tutorial lengkap menggunakan AI untuk pemula',
            'ChatGPT, Midjourney',
            date('Y-m-d H:i:s'),
        ]) . "\n";

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="challenge_submission_template.csv"')
            ->setBody($csv);
    }

    /**
     * Download sample CSV template
     */
    public function downloadTemplate()
    {
        $csv = implode(',', [
            'source',
            'program',
            'fullname',
            'email',
            'whatsapp',
            'birthday',
            'gender',
            'province',
            'city',
            'occupation',
            'work_experience',
            'skill',
            'institution',
            'major',
            'semester',
            'grade',
            'type_of_business',
            'business_duration',
            'education_level',
            'graduation_year',
            'link_business',
            'last_project',
            'wa_group_link',
            'created_at',
            'updated_at',
            'deleted_at',
        ]) . "\n";

        // Add sample data
        $csv .= implode(',', [
            'typeform',
            'GenAI Beginner',
            'John Doe',
            'john@example.com',
            '081234567890',
            '1990-01-01',
            'male',
            '31',
            '3171',
            'Pelajar/Mahasiswa',
            '0-1 tahun',
            'Python, AI',
            'Universitas Indonesia',
            'Teknik Informatika',
            '6',
            '3.5',
            '',
            '',
            'S1',
            '2024',
            '',
            'Portfolio project',
            'https://chat.whatsapp.com/xxx',
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
            '',
        ]) . "\n";

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="challenge_import_template.csv"')
            ->setBody($csv);
    }
}
