<?php

namespace App\Controllers\Api;

use App\Models\OtpWhatsappModel;
use App\Models\ScholarshipParticipantModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class ScholarshipController extends ResourceController
{
    use ResponseTrait;

    protected $db;
    protected $table            = 'scholarship_participants';
    protected $format           = 'json';
    private $disallowed_domains = [
        'mailinator.com',
        'guerrillamail.com',
        '10minutemail.com',
        'tempmail.com',
        'yopmail.com',
        'throwawaymail.com',
        'emailondeck.com',
        'fakemailgenerator.com',
        'mohmal.com',
        'getnada.com',
        'mytemp.email',
        'maildrop.cc',
        'dispostable.com',
        'mailnesia.com',
        'tempinbox.com',
        'spambog.com',
        'trashmail.com',
        'temp-mail.org',
        'sharklasers.com',
        'mailcatch.com',
        'inboxbear.com',
        'codepolitan.com',
    ];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function checkToken()
    {
        $Heroic = new \App\Libraries\Heroic();

        return $Heroic->checkToken();
    }

    public function index()
    {
        $data = 'Test Controllers';

        return $this->response->setJSON($data);
    }

    public function register()
    {
        $data   = $this->request->getPost();
        $Heroic = new \App\Libraries\Heroic();

        // Minimum validate
        if (! isset($data['fullname'], $data['email'])) {
            return $this->failValidationErrors(['message' => 'Mohon untuk melengkapi data.']);
        }

        if ($this->isDisallowedDomain($data['email'])) {
            return $this->fail(['status' => 'failed', 'message' => 'Domain email tidak diizinkan.']);
        }

        // Check valid referral
        $participantModel = new ScholarshipParticipantModel();

        // Process mentee of co-mentor registration
        $data['prev_chapter'] = $data['program'];
        if (isset($data['reference']) && $data['program'] === 'RuangAI2025CM') {
            $participantCM      = $participantModel->where('referral_code_comentor', $data['reference'])->where('deleted_at', null)->first();

            if (! $participantCM) {
                return $this->fail(['status' => 'failed', 'message' => 'Referral code tidak valid. Periksa kembali link co-mentor']);
            }

            // Add this user to active program
            $activeProgram = $this->db->table('events')
                ->select('code')
                ->where('status', 'ongoing')
                ->get()
                ->getRowArray()['code'] ?? null;
            $data['program'] = $activeProgram;
            $data['reference_comentor'] = strtolower($data['reference']);
            $data['reference'] = null;
        }

        // Get JWT from headers
        // $jwt = $this->checkToken();

        // Compare JWT with data otp_whatsapps
        // $otpModel = new OtpWhatsappModel();
        // $isRegistered = $otpModel->where('whatsapp_number', $Heroic->normalizePhoneNumber($jwt->whatsapp_number))->first();

        // if (!$isRegistered) {
        //     return $this->fail(['status' => 'failed', 'message' => 'Autentikasi gagal.']);
        // }

        $number = $Heroic->normalizePhoneNumber($data['whatsapp_number']);

        $userModel = new UserModel();
        $user      = $userModel->groupStart()
            ->where('LOWER(email)', strtolower($data['email']))
            ->orWhere('phone', $number)
            ->groupEnd()
            ->where('deleted_at', null)
            ->first();

        if ($user) {
            return $this->fail(['status' => 'failed', 'message' => 'Akun sudah pernah terdaftar.']);
        }

        // Get username from fullname, remove space and lowercase all with sufix random
        $username = str_replace(' ', '', strtolower($data['fullname'])) . '_' . bin2hex(random_bytes(4));

        $Phpass   = new \App\Libraries\Phpass();
        $password = $Phpass->HashPassword($data['password']);
        $userId   = $userModel->insert([
            'name'     => $data['fullname'],
            'username' => $username,
            'email'    => strtolower($data['email']),
            'phone'    => $number,
            'pwd'      => $password,
        ]);

        // if failed insert users
        if (! $userId) {
            return $this->fail(['status' => 'failed', 'message' => 'Registrasi gagal.']);
        }

        $data['user_id']       = $userId;
        $data['whatsapp']      = $number;
        $data['referral_code'] = strtoupper(substr(uniqid(), -6));
        $data['status']        = 'terdaftar';

        // Check existing by user_id before insert
        $participant = $participantModel->where('user_id', $userId)->where('deleted_at', null)->first();

        if ($participant) {
            return $this->fail(['status' => 'failed', 'message' => 'Beasiswa sudah pernah terdaftar.']);
        }

        // Insert data to scholarship_participants
        $data['semester']                          = ! empty($data['semester']) ? $data['semester'] : 0;
        $data['grade']                             = ! empty($data['grade']) ? $data['grade'] : 0;
        $data['accept_terms']                      = ! empty($data['accept_terms']) ? $data['accept_terms'] : 0;
        $data['accept_agreement']                  = ! empty($data['accept_agreement']) ? $data['accept_agreement'] : 0;
        $data['is_participating_other_ai_program'] = ! empty($data['is_participating_other_ai_program']) ? $data['is_participating_other_ai_program'] : 0;

        $data['reference'] = strtolower($data['reference']);
        $participantModel->insert($data);

        // Insert data to course_students
        $courseStudentModel = new \Course\Models\CourseStudentModel();
        $courseStudentModel->insert([
            'user_id'    => $userId,
            'course_id'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Jwt only email, whatsapp_number, user_id
        $jwt = JWT::encode([
            'email'           => strtolower($data['email']),
            'whatsapp_number' => $number,
            'user_id'         => $userId,
        ], config('Heroic')->jwtKey['secret'], 'HS256');

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Registrasi berhasil, selamat anda telah mendapatkan Beasiswa RuangAI.',
            'token'   => $jwt,
        ]);
    }

    public function userReferral()
    {
        $jwt              = $this->checkToken();
        $participantModel = new ScholarshipParticipantModel();
        $Heroic           = new \App\Libraries\Heroic();

        $leader = $participantModel
            ->select('scholarship_participants.*, events.title as program_title, events.telegram_link, events.date_start')
            ->join('events', 'events.code = scholarship_participants.program', 'left')
            ->where('scholarship_participants.whatsapp', $jwt->whatsapp_number)
            ->orWhere('scholarship_participants.whatsapp', $Heroic->normalizePhoneNumber($jwt->whatsapp_number))
            ->where('scholarship_participants.deleted_at', null)
            ->orderBy('scholarship_participants.created_at', 'DESC')
            ->first();

        if (! $leader) {
            return $this->respond(['status' => 'failed', 'message' => 'Pengguna tidak ditemukan.']);
        }

        // Get data bank from user profile
        $userProfileModel = new \App\Models\UserProfile();
        $profile          = $userProfileModel->where('user_id', $leader['user_id'])->where('deleted_at', null)->first();

        // Save bank on type object
        $bank = null;
        if ($profile) {
            $bank = (object) [
                'bank_name'           => $profile['bank_name'],
                'account_name'        => $profile['account_name'],
                'account_number'      => $profile['account_number'],
                'identity_card_image' => $profile['identity_card_image'],
            ];
        }

        $memberQuery = $participantModel->select("
                scholarship_participants.fullname,
                scholarship_participants.program,
                scholarship_participants.created_at as joined_at, 
                course_students.graduate, 
                course_students.progress, 
                COUNT(CASE WHEN live_attendance.status = 1 THEN 1 END) as total_live_session
            ")
            ->join('course_students', 'course_students.user_id = scholarship_participants.user_id', 'left')
            ->join('live_attendance', 'live_attendance.user_id = scholarship_participants.user_id', 'left')
            ->where('scholarship_participants.reference', $leader['referral_code'])
            ->where('scholarship_participants.deleted_at', null)
            ->groupBy([
                'scholarship_participants.user_id',
                'scholarship_participants.program',
                'scholarship_participants.fullname',
                'scholarship_participants.created_at',
                'course_students.graduate',
                'course_students.progress'
            ])
            ->get();

        $members = $memberQuery->getResultArray();

        foreach ($members as $key => $member) {
            $members[$key]['status'] = $member['graduate'] == 1 ? 'lulus' : 'terdaftar';
        }

        // Filter member graduated by status completed
        $totalGraduated = count(array_filter($members, static fn($member) => $member['status'] === 'lulus'));

        // Get graduated per program
        $graduatedPerProgram = array_reduce($members, function ($carry, $member) {
            $program = $member['program'];
            $status  = $member['status'];

            if (! isset($carry[$program])) {
                $carry[$program] = 0;
            }

            if ($status === 'lulus') {
                $carry[$program]++;
            }

            return $carry;
        }, []);

        $commision = $leader['commission_per_graduate'];
        $disbursed = $leader['withdrawal'];
        $referral = model('ReferralModel')->where('user_id', $leader['user_id'])->first();

        $data['withdrawal']         = model('ReferralWithdrawalModel')->select('amount, withdrawn_at, description, created_at')->where('user_id', $leader['user_id'])->get()->getResultArray();
        $data['referral_code']      = $leader['referral_code'];
        $data['is_sponsorship']     = $leader['is_sponsorship'] === 1 ? true : false;
        $data['program']            = $leader['program'];
        $data['program_title']      = $leader['program_title'];
        $data['program_date_start'] = $leader['date_start'];
        $data['telegram_link']      = $leader['telegram_link'];
        $data['bank']               = $bank;
        $data['members']            = $members;
        $data['total_member']       = $memberQuery->getNumRows();
        $data['total_graduated']    = (int) $referral['total_referral_graduate'] || 0;
        $data['total_commission']   = (int) $referral['balance'] || 0;
        $data['total_disbursed']    = (int) $referral['withdrawal'] || 0;
        $data['graduated']          = $graduatedPerProgram;

        return $this->respond($data);
    }

    public function program()
    {
        $programCode = $this->request->getGet('name');

        $scholarshipModel   = new ScholarshipParticipantModel();
        $courseStudentModel = new \Course\Models\CourseStudentModel();
        $eventModel         = new \App\Models\Events();

        if ($programCode && ! in_array($programCode, ['RuangAI2025B1', 'RuangAI2025B2'])) {
            $masterProgram   = $eventModel->where('code', $programCode)->first();
            $program         = $masterProgram['title'];
            $data['program'] = $program;
        }

        $user_registered = $scholarshipModel
            ->where('deleted_at', null)
            ->countAllResults();

        $db = \Config\Database::connect();
        $activeProgram = $db->table('events')
                ->select('code')
                ->where('status', 'ongoing')
                ->get()
                ->getRowArray()['code'] ?? null;

        $count_user_progress = $courseStudentModel
            ->select('scholarship_participants.program, scholarship_participants.reference')
            ->join('scholarship_participants', 'scholarship_participants.user_id = course_students.user_id')
            ->where('course_students.progress >', 0)
            ->groupStart()
                ->where('course_students.graduate', 0)
                ->orWhere('course_students.graduate', null)
            ->groupEnd()
            ->where('course_students.expire_at', null)
            ->where('course_students.course_id', 1)
            ->where('scholarship_participants.program', $activeProgram)
            ->countAllResults();

        if ($programCode === 'RuangAI2025B1') {
            $quota      = $masterProgram['quota'];
            $quota_used = $scholarshipModel->where('program', $programCode)->where('deleted_at', null)->countAllResults();
            $graduated  = $courseStudentModel->where('course_id', 1)->where('graduate', 1)->where('deleted_at', null)->countAllResults();

            $data['quota']         = $quota ?? 0;
            $data['quota_used']    = $quota_used ?? 0;
            $data['quota_left']    = $quota - $graduated;
            $data['graduated']     = $graduated ?? 0;
            $data['user_progress'] = $count_user_progress;
        }

        if ($programCode === 'RuangAI2025B2') {
            $graduated       = $courseStudentModel->join('scholarship_participants', 'scholarship_participants.user_id = course_students.user_id')
                ->where('scholarship_participants.program', $programCode)
                ->where('course_students.graduate', 1)
                ->where('course_students.deleted_at', null)
                ->countAllResults();

            $data['user_registered'] = $user_registered ?? 0;
            $data['user_progress']   = $count_user_progress;
            $data['graduated']       = $graduated ?? 0;
        }

        if (!$programCode) {
            $graduatedB1 = $db->table('view_participants')
                ->where('program', 'RuangAI2025B1')
                ->where('graduate', 1)
                ->where('prev_chapter !=', 'RuangAI2025CM')
                ->countAllResults();

            $graduatedB2 = $db->table('view_participants')
                ->where('program', 'RuangAI2025B2')
                ->where('graduate', 1)
                ->where('prev_chapter !=', 'RuangAI2025CM')
                ->countAllResults();

            $graduatedB3 = $db->table('view_participants')
                ->where('program', 'RuangAI2025B3')
                ->where('graduate', 1)
                ->where('prev_chapter !=', 'RuangAI2025CM')
                ->countAllResults();

            $data['user_registered'] = $user_registered ?? 0;
            $data['user_progress']   = $count_user_progress;
            $data['graduated']       = (object) [
                'RuangAI2025B1' => $graduatedB1 ?? 0,
                'RuangAI2025B2' => $graduatedB2 ?? 0,
                'RuangAI2025B3' => $graduatedB3 ?? 0,
            ];
        }

        return $this->respond($data);
    }

    public function isDisallowedDomain($email)
    {
        // Pisahkan email menjadi username dan domain
        [$user, $domain] = explode('@', strtolower($email));

        // Cek apakah domain ada di dalam daftar disallowed_domains
        if (in_array($domain, $this->disallowed_domains, true)) {
            return true;
        }

        return false;
    }

    public function frontendSettings()
    {
        $db                    = \Config\Database::connect();
        $course                = $db->table('courses')->where('id', 1)->get()->getRowArray();
        $data['publish_class'] = $course['status'] === 'publish' ? true : false;

        return $this->respond($data);
    }

    public function syncGraduatedB1()
    {
        // Get course_students yang progressnya sudah 100 tapi graduate masih 0
        $courseStudentModel = new \Course\Models\CourseStudentModel();
        $students           = $courseStudentModel->select('course_students.user_id, progress, graduate')
            ->where('course_id', 1)
            ->where('course_students.graduate', 0)
            ->where('course_students.progress', 100)
            ->get()
            ->getResultArray();
        if ($students) {
            echo 'Ada ' . count($students) . ' student yang 100% progress dan belum ditandai lulus <br>';

            $students = array_column($students, 'user_id');

            // Count live attendance
            $liveAttendanceModel = new \App\Models\LiveAttendance();
            $live_attendance     = $liveAttendanceModel->select('user_id, COUNT(DISTINCT live_meeting_id) as total')
                ->where('course_id', 1)
                ->whereIn('user_id', $students)
                ->groupBy('user_id')
                ->having('COUNT(DISTINCT live_meeting_id) >=', 3)
                ->get()
                ->getResultArray();

            if ($live_attendance) {
                echo 'Ada ' . count($live_attendance) . ' student yang hadir di >= 3 live meeting <br>';

                $live_attendance = array_combine(array_column($live_attendance, 'user_id'), array_column($live_attendance, 'total'));
                $graduated       = array_keys($live_attendance);

                // Update graduate menjadi 1
                $courseStudentModel->whereIn('user_id', $graduated)
                    ->set(['graduate' => 1])
                    ->update();

                // Update status menjadi lulus
                $participantModel = new ScholarshipParticipantModel();
                $participantModel->where('program', 'RuangAI2025B1')
                    ->whereIn('user_id', $graduated)
                    ->set(['status' => 'lulus'])
                    ->update();

                echo 'Updated: ' . $courseStudentModel->affectedRows() . ' rows & ' . $participantModel->affectedRows() . ' rows';
            } else {
                echo 'Belum ada yang hadir di minimal 3 live meeting';
            }
        } else {
            echo 'Belum ada student yang 100% progress';
        }
    }

    public function generateTokenUserGraduate()
    {
        $program = $this->request->getVar('program');
        $course_id = $this->request->getVar('course_id');

        $programExists = ['RuangAI2025B2'];
        if (!in_array($program, $programExists)) {
            return $this->respond([
                'status'  => 'failed',
                'message' => 'Program tidak ditemukan'
            ]);
        }

        $bulkGenerate = model('UserToken')->generateByGraduate($program, $course_id);

        if($bulkGenerate['status'] == 'success') {
            $course = model('Course')->find($course_id);
            return $this->respond([
                'status' => 'success',
                'message' => $bulkGenerate['total_generated'] . ' peserta ' .  $program . ' Course ' . $course['course_title'] . ' berhasil mendapatkan token dari kelulusan'
            ]);
        }
    }
}
