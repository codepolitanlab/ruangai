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
    protected $table = 'scholarship_participants';
    protected $format = 'json';

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
        'codepolitan.com'
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
        $data = $this->request->getPost();
        $Heroic = new \App\Libraries\Heroic();

        // Minimum validate
        if (!isset($data['fullname'], $data['email'])) {
            return $this->failValidationErrors(['message' => 'Mohon untuk melengkapi data.']);
        }

        if ($this->isDisallowedDomain($data['email'])) {
            return $this->fail(['status' => 'failed', 'message' => 'Domain email tidak diizinkan.']);
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
        $user = $userModel->groupStart()
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

        $Phpass = new \App\Libraries\Phpass();
        $password = $Phpass->HashPassword($data['password']);
        $userId = $userModel->insert([
            'name'     => $data['fullname'],
            'username' => $username,
            'email'    => strtolower($data['email']),
            'phone'    => $number,
            'pwd'      => $password,
        ]);

        // if failed insert users
        if (!$userId) {
            return $this->fail(['status' => 'failed', 'message' => 'Registrasi gagal.']);
        }

        $data['user_id'] = $userId;
        $data['whatsapp'] = $number;
        $data['referral_code'] = strtoupper(substr(uniqid(), -6));
        $data['status'] = 'terdaftar';

        $participantModel = new ScholarshipParticipantModel();

        // Check existing by user_id before insert
        $participant = $participantModel->where('user_id', $userId)->where('deleted_at', null)->first();

        if ($participant) {
            return $this->fail(['status' => 'failed', 'message' => 'Beasiswa sudah pernah terdaftar.']);
        }
        
        // Insert data to scholarship_participants
        $data['semester'] = ! empty($data['semester']) ? $data['semester'] : 0;
        $data['grade'] = ! empty($data['grade']) ? $data['grade'] : 0;
        $data['accept_terms'] = ! empty($data['accept_terms']) ? $data['accept_terms'] : 0;
        $data['accept_agreement'] = ! empty($data['accept_agreement']) ? $data['accept_agreement'] : 0;
        $data['is_participating_other_ai_program'] = ! empty($data['is_participating_other_ai_program']) ? $data['is_participating_other_ai_program'] : 0;

        $participantModel->insert($data);

        // Insert data to course_students
        $courseStudentModel = new \App\Models\CourseStudent();
        $courseStudentModel->insert([
            'user_id' => $userId,
            'course_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Jwt only email, whatsapp_number, user_id
        $jwt = JWT::encode([
            'email' => strtolower($data['email']),
            'whatsapp_number' => $number,
            'user_id' => $userId
        ], config('Heroic')->jwtKey['secret'], 'HS256');

        return $this->respondCreated([
            'status' => 'success',
            'message' => 'Registrasi berhasil, selamat anda telah mendapatkan Beasiswa RuangAI.',
            'token' => $jwt
        ]);
    }

    public function userReferral()
    {
        $jwt = $this->checkToken();
        $participantModel = new ScholarshipParticipantModel();
        $Heroic = new \App\Libraries\Heroic();

        $leader = $participantModel
            ->select('scholarship_participants.*, events.title as program_title, events.telegram_link, events.date_start')
            ->join('events', 'events.code = scholarship_participants.program', 'left')
            ->where('scholarship_participants.whatsapp', $jwt->whatsapp_number)
            ->orWhere('scholarship_participants.whatsapp', $Heroic->normalizePhoneNumber($jwt->whatsapp_number))
            ->where('scholarship_participants.deleted_at', null)
            ->orderBy('scholarship_participants.created_at', 'DESC')
            ->first();

        if (!$leader) {
            return $this->respond(['status' => 'failed', 'message' => 'Pengguna tidak ditemukan.']);
        }

        // Get data bank from user profile
        $userProfileModel = new \App\Models\UserProfile();
        $profile = $userProfileModel->where('user_id', $leader['user_id'])->where('deleted_at', null)->first();

        // Save bank on type object
        $bank = null;
        if ($profile) {
            $bank = (object) [
                'bank_name'      => $profile['bank_name'],
                'account_name'   => $profile['account_name'],
                'account_number' => $profile['account_number'],
                'identity_card_image' => $profile['identity_card_image'],
            ];
        }

        $memberQuery = $participantModel->select('fullname, status, created_at as joined_at')
            ->where('reference', $leader['referral_code'])
            ->where('deleted_at', null)
            ->get();

        $members = $memberQuery->getResultArray();

        // Filter member graduated by status completed
        $graduated = count(array_filter($members, function ($member) {
            return $member['status'] === 'lulus';
        }));

        $commision = 5000;
        $disbursed = 0;

        $data['referral_code'] = $leader['referral_code'];
        $data['program'] = $leader['program'];
        $data['program_title'] = $leader['program_title'];
        $data['program_date_start'] = $leader['date_start'];
        $data['telegram_link'] = $leader['telegram_link'];
        $data['bank'] = $bank;
        $data['members'] = $members;
        $data['total_member'] = $memberQuery->getNumRows();
        $data['total_graduated'] = $graduated;
        $data['total_commission'] = $commision * $graduated;
        $data['total_disbursed'] = $disbursed;

        return $this->respond($data);
    }

    public function program()
    {
        $program = $this->request->getGet('name');

        if ($program === 'RuangAI2025B1') {
            $scholarshipModel = new ScholarshipParticipantModel();
            $eventModel = new \App\Models\Events();

            $masterProgram = $eventModel->where('code', 'RuangAI2025B1')->first();
            $program = $masterProgram['title'];
            $quota = $masterProgram['quota'];
            $quota_used = $scholarshipModel->where('program', 'RuangAI2025B1')->where('deleted_at', null)->countAllResults();
            $graduated = $scholarshipModel->where('program', 'RuangAI2025B1')->where('deleted_at', null)->where('status', 'lulus')->countAllResults();

            $courseStudentModel = new \App\Models\CourseStudent();
            
            $count_user_progress = $courseStudentModel
                        ->select('course_students.user_id')
                        ->join('live_attendance', 'live_attendance.user_id = course_students.user_id', 'left')
                        ->where('course_students.course_id', 1)
                        ->where('course_students.progress >', 10)
                        ->groupBy('course_students.user_id')
                        ->having('COUNT(live_attendance.id) >=', 3)
                        ->countAllResults(); // Ini akan menghitung baris setelah grouping dan having
        }

        $data['program'] = $program;
        $data['quota'] = $quota ?? 0;
        $data['quota_used'] = $quota_used ?? 0;
        $data['quota_left'] = $quota - $graduated;
        $data['graduated'] = $graduated ?? 0;
        $data['user_progress'] = $count_user_progress;

        return $this->respond($data);
    }

    public function isDisallowedDomain($email)
    {
        // Pisahkan email menjadi username dan domain
        list($user, $domain) = explode('@', strtolower($email));

        // Cek apakah domain ada di dalam daftar disallowed_domains
        if (in_array($domain, $this->disallowed_domains)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function frontendSettings()
    {
        $db = \Config\Database::connect();
        $course = $db->table('courses')->where('id', 1)->get()->getRowArray();
        $data['publish_class'] = $course['status'] == 'publish' ? true : false;
        
        return $this->respond($data);
    }

    public function syncGraduatedB1()
    {
        // Get student from course id 1 which has graduated
        $courseStudentModel = new \App\Models\CourseStudent();
        $graduated = $courseStudentModel->select('course_students.user_id')
                                        ->join('scholarship_participants', 'scholarship_participants.user_id = course_students.user_id')
                                        ->where('program', 'RuangAI2025B1')
                                        ->where('course_id', 1)
                                        ->where('course_students.graduate', 1)
                                        ->where('scholarship_participants.status !=', 'lulus')
                                        ->get()
                                        ->getResultArray();
        if($graduated) {
            $graduated = array_column($graduated, 'user_id');

            $participantModel = new ScholarshipParticipantModel();
            $participantModel->where('program', 'RuangAI2025B1')
                            ->whereIn('user_id', $graduated)
                            ->set(['status' => 'lulus'])
                            ->update();
            $result = $participantModel->affectedRows();
            echo "Updated: " . $result . " rows from " . count($graduated) . " rows";
        } else {
            echo "No update";
        }
    }
}
