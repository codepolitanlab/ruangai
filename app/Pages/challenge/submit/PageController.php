<?php

namespace App\Pages\challenge\submit;

use App\Pages\BaseController;
use Challenge\Models\ChallengeAlibabaModel;
use Challenge\Config\Challenge as ChallengeConfig;

class PageController extends BaseController
{
    protected $model;
    protected $config;

    public $data = [
        'page_title' => 'Submit Challenge - WAN Vision Clash',
        'module' => 'challenge',
        'active_page' => 'challenge_submit',
    ];

    public function __construct()
    {
        $this->model = new ChallengeAlibabaModel();
        $this->config = new ChallengeConfig();
        helper('challenge');

        $this->data['module'] = 'challenge';
        $this->data['active_page'] = 'challenge_submit';
    }

    /**
     * Display submission form
     */
    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);

        // Check if registration is open
        // if (!$this->config->isRegistrationOpen()) {
        //     return $this->respond([
        //         'success' => 0,
        //         'message' => 'Pendaftaran belum dibuka atau sudah ditutup',
        //         'registration_start' => $this->config->registrationStart,
        //         'registration_end' => $this->config->registrationEnd,
        //     ]);
        // }

        // Check if user has an existing submission (we will still allow edit if status is pending)
        $existingSubmission = $this->model->getUserSubmission($jwt->user_id);

        if ($existingSubmission) {
            // If not pending, we block new submissions
            if ($existingSubmission['status'] !== 'pending') {
                return $this->respond([
                    'success' => 0,
                    'message' => 'Anda sudah memiliki submission aktif. Satu akun hanya boleh submit satu kali.',
                    'existing_submission' => $existingSubmission,
                ]);
            }

            $this->data['existing_submission'] = $existingSubmission;
            $this->data['can_edit'] = true;
        } else {
            $this->data['existing_submission'] = null;
            $this->data['can_edit'] = false;
        }

        // Get basic user info (other profile fields moved to user_profiles)
        $db = \Config\Database::connect();
        $user = $db->table('users')
            ->select('id, name, email, phone, email_valid')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        // Load profile from user_profiles and prefer those values
        $profile = $db->table('user_profiles')
            ->where('user_id', $jwt->user_id)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        $user = $user ?? [];

        $user['gender'] = $profile['gender'] ?? null;
        $user['alibaba_cloud_id'] = $profile['alibaba_cloud_id'] ?? null;
        $user['alibaba_cloud_screenshot'] = $profile['alibaba_cloud_screenshot'] ?? null;
        $user['occupation'] = $profile['occupation'] ?? null;
        $user['institution'] = $profile['institution'] ?? null;
        $user['birthday'] = $profile['birthday'] ?? null;
        $user['x_profile_url'] = $profile['x_profile_url'] ?? null;

        $this->data['user'] = $user;

        // Indicate success
        $this->data['success'] = 1;
        return $this->respond($this->data);
    }

    /**
     * Handle form submission
     */
    public function postIndex()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);

        // Check if registration is open
        if (!$this->config->isRegistrationOpen()) {
            return $this->respond([
                'success' => 0,
                'errors' => ['general' => 'Pendaftaran belum dibuka atau sudah ditutup'],
            ]);
        }

        // Determine if this is an update or new submission
        $submissionId = $this->request->getPost('submission_id');
        $isUpdate = false;

        if ($submissionId) {
            // Verify user can edit this submission
            if (!$this->model->canEdit($submissionId, $jwt->user_id)) {
                return $this->respond([
                    'success' => 0,
                    'errors' => ['general' => 'Anda tidak dapat mengedit submission ini'],
                ]);
            }
            $isUpdate = true;
        } else {
            // For new submissions, ensure there's no active (non-rejected) submission
            $existingSubmission = $this->model->getUserSubmission($jwt->user_id);
            if ($existingSubmission) {
                return $this->respond([
                    'success' => 0,
                    'errors' => ['general' => 'Anda sudah memiliki submission aktif'],
                ]);
            }
        }

        // Validation rules
        $validation = service('validation');
        $validation->setRules([
            'twitter_post_url' => [
                'rules' => 'required|valid_url',
                'errors' => [
                    'required' => 'URL post Twitter wajib diisi',
                    'valid_url' => 'URL tidak valid',
                ],
            ],
            'video_title' => [
                'rules' => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required' => 'Judul video wajib diisi',
                    'min_length' => 'Judul video minimal 5 karakter',
                    'max_length' => 'Judul video maksimal 255 karakter',
                ],
            ],
            'video_description' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Deskripsi video wajib diisi',
                    'min_length' => 'Deskripsi video minimal 10 karakter',
                ],
            ],
        ]);

        if (!$validation->run($this->request->getPost())) {
            return $this->respond([
                'success' => 0,
                'errors' => $validation->getErrors(),
            ]);
        }

        // Validate Twitter URL format
        $twitterUrl = $this->request->getPost('twitter_post_url');
        $challengeRules = new \Challenge\Validation\ChallengeRules();
        $error = '';
        
        if (!$challengeRules->twitter_url_format($twitterUrl, $error)) {
            return $this->respond([
                'success' => 0,
                'errors' => ['twitter_post_url' => $error],
            ]);
        }

        // Handle file uploads
        $uploadedFiles = [];
        $uploadPath = ensure_upload_directory($jwt->user_id);

        // For update, fetch existing submission files
        $existingFiles = [];
        if ($isUpdate) {
            $existing = $this->model->find($submissionId);
            $existingFiles = [
                'prompt_file' => $existing['prompt_file'] ?? null,
            ];
        }

        try {
            // Upload prompt file (PDF/TXT)
            $promptFile = $this->request->getFile('prompt_file');
            if ($promptFile && $promptFile->isValid() && !$promptFile->hasMoved()) {
                // Validate file size (max 1MB)
                if ($promptFile->getSize() > 1048576) { // 1MB = 1048576 bytes
                    throw new \Exception('Ukuran file maksimal 1MB');
                }
                
                // Replace old file on update
                if ($isUpdate && !empty($existingFiles['prompt_file'])) {
                    $oldFile = $uploadPath . $existingFiles['prompt_file'];
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                $promptFileName = $promptFile->getRandomName();
                $promptFile->move($uploadPath, $promptFileName);
                $uploadedFiles['prompt_file'] = $promptFileName;
            } elseif ($isUpdate && !empty($existingFiles['prompt_file'])) {
                // Keep existing prompt file if not re-uploaded
                $uploadedFiles['prompt_file'] = $existingFiles['prompt_file'];
            } else {
                throw new \Exception('Prompt file wajib diupload');
            }

        } catch (\Exception $e) {
            // Clean up any uploaded files on error
            foreach ($uploadedFiles as $file) {
                if (file_exists($uploadPath . $file)) {
                    unlink($uploadPath . $file);
                }
            }

            return $this->respond([
                'success' => 0,
                'errors' => ['files' => $e->getMessage()],
            ]);
        }

        // Prepare data for database
        $data = [
            'twitter_post_url' => $this->request->getPost('twitter_post_url'),
            'video_title' => $this->request->getPost('video_title'),
            'video_description' => $this->request->getPost('video_description'),
            'other_tools' => !empty($this->request->getPost('other_tools')) ? $this->request->getPost('other_tools') : null,
            'prompt_file' => $uploadedFiles['prompt_file'],
            'ethical_statement_agreed' => $this->request->getPost('ethical_statement_agreed') == '1' ? 1 : 0,
            'is_followed_account_codepolitan' => $this->request->getPost('is_followed_account_codepolitan') == '1' ? 1 : 0,
            'is_followed_account_alibaba' => $this->request->getPost('is_followed_account_alibaba') == '1' ? 1 : 0,
        ];

        if ($isUpdate) {
            // Update existing submission
            $success = $this->model->update($submissionId, $data);
            
            if (!$success) {
                return $this->respond([
                    'success' => 0,
                    'errors' => ['general' => 'Gagal mengupdate submission. Silakan coba lagi.'],
                ]);
            }

            return $this->respond([
                'success' => 1,
                'message' => 'Submission berhasil diupdate!',
                'submission_id' => $submissionId,
            ]);
        } else {
            // Create new submission
            $data['user_id'] = $jwt->user_id;
            $data['challenge_id'] = $this->config->challengeId;
            $data['status'] = 'pending';
            $data['submitted_at'] = date('Y-m-d H:i:s');

            $newSubmissionId = $this->model->insert($data);

            if (!$newSubmissionId) {
                // Clean up uploaded files
                foreach ($uploadedFiles as $file) {
                    if ($file && file_exists($uploadPath . $file)) {
                        unlink($uploadPath . $file);
                    }
                }

                return $this->respond([
                    'success' => 0,
                    'errors' => ['general' => 'Gagal menyimpan submission. Silakan coba lagi.'],
                ]);
            }

            return $this->respond([
                'success' => 1,
                'message' => 'Submission berhasil dikirim!',
                'submission_id' => $newSubmissionId,
            ]);
        }

    }

    /**
     * Save user profile (ajax)
     */
    public function postSaveProfile()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);

        $validation = service('validation');
        $validation->setRules([
            'whatsapp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'WhatsApp wajib diisi',
                ]
            ],
            'birthday' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal lahir wajib diisi',
                    'valid_date' => 'Format tanggal tidak valid'
                ]
            ],
            'gender' => [
                'rules' => 'required|in_list[male,female]',
                'errors' => [
                    'required' => 'Jenis kelamin wajib dipilih',
                    'in_list' => 'Pilihan jenis kelamin tidak valid'
                ]
            ],
            'occupation' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Profesi wajib diisi'
                ]
            ],
            'institution' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Instansi/Perusahaan wajib diisi'
                ]
            ],
            'alibaba_cloud_id' => [
                'rules' => 'required|numeric|min_length[15]',
                'errors' => [
                    'required' => 'AlibabaCloud ID wajib diisi',
                    'numeric' => 'AlibabaCloud ID harus berupa angka',
                    'min_length' => 'AlibabaCloud ID minimal 15 karakter'
                ]
            ],
            'x_profile_url' => [
                'rules' => 'required|valid_url|regex_match[/^https:\\/\\/(www\\.)?(x\\.com|twitter\\.com)\\/.+/]',
                'errors' => [
                    'required' => 'Link Profil X wajib diisi',
                    'valid_url' => 'Format URL tidak valid',
                    'regex_match' => 'Link harus dari domain x.com atau twitter.com'
                ]
            ],
        ]);

        $post = $this->request->getPost();
        if (!$validation->run($post)) {
            return $this->respond([
                'success' => 0, 
                'message' => 'Mohon lengkapi semua field yang wajib diisi dengan benar',
                'errors' => $validation->getErrors()
            ]);
        }

        // Validate minimum age 17 years
        if (!empty($post['birthday'])) {
            $birthDate = new \DateTime($post['birthday']);
            $today = new \DateTime();
            $age = $today->diff($birthDate)->y;
            
            if ($age < 17) {
                return $this->respond([
                    'success' => 0,
                    'message' => 'Usia minimal 17 tahun',
                    'errors' => ['birthday' => 'Usia minimal 17 tahun']
                ]);
            }
        }

        // Check if user already has screenshot or is uploading one from user_profiles
        $db = \Config\Database::connect();
        $profileModel = new \App\Models\UserProfile();
        $existingProfile = $profileModel->where('user_id', $jwt->user_id)->where('deleted_at', null)->first();
        
        $screenshot = $this->request->getFile('alibaba_cloud_screenshot');
        $hasScreenshot = ($existingProfile && !empty($existingProfile['alibaba_cloud_screenshot'])) || ($screenshot && $screenshot->isValid());
        
        if (!$hasScreenshot) {
            return $this->respond([
                'success' => 0,
                'message' => 'Screenshot Alibaba Account wajib diupload',
                'errors' => ['alibaba_cloud_screenshot' => 'Screenshot Alibaba Account wajib diupload']
            ]);
        }

        // Prepare user update (only name and email in users table)
        $userUpdate = [
            'name' => $post['name'],
            'email' => $post['email'],
        ];

        // Prepare profile payload for user_profiles table
        $profilePayload = [
            'user_id' => $jwt->user_id,
            'alibaba_cloud_id' => $post['alibaba_cloud_id'] ?? null,
            'whatsapp' => $post['whatsapp'] ?? null,
            'gender' => $post['gender'] ?? null,
            'occupation' => $post['occupation'] ?? null,
            'institution' => $post['institution'] ?? null,
            'birthday' => $post['birthday'] ?? null,
            'x_profile_url' => $post['x_profile_url'] ?? null,
        ];

        // Handle optional screenshot upload
        if ($screenshot && $screenshot->isValid() && !$screenshot->hasMoved()) {
            // Validate file size (max 1MB)
            if ($screenshot->getSize() > 1048576) { // 1MB = 1048576 bytes
                return $this->respond([
                    'success' => 0,
                    'message' => 'Ukuran file maksimal 1MB',
                    'errors' => ['alibaba_cloud_screenshot' => 'Ukuran file maksimal 1MB']
                ]);
            }
            
            $uploadPath = ensure_profile_upload_directory($jwt->user_id);
            $fileName = $screenshot->getRandomName();
            $screenshot->move($uploadPath, $fileName);
            $profilePayload['alibaba_cloud_screenshot'] = $fileName;
            
            // Delete old screenshot if exists
            if ($existingProfile && !empty($existingProfile['alibaba_cloud_screenshot'])) {
                $oldFile = $uploadPath . $existingProfile['alibaba_cloud_screenshot'];
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }
        }

        // Update users table (name and email only)
        $db->table('users')->where('id', $jwt->user_id)->update($userUpdate);

        // Upsert user_profiles
        if ($existingProfile) {
            $saved = $profileModel->update($existingProfile['id'], $profilePayload);
        } else {
            $saved = $profileModel->insert($profilePayload);
        }

        if ($saved) {
            return $this->respond(['success' => 1, 'message' => 'Profil berhasil disimpan']);
        }

        return $this->respond(['success' => 0, 'message' => 'Gagal menyimpan profil']);
    }
}
