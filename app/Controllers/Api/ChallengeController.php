<?php

namespace App\Controllers\Api;

use App\Models\ChallengeAlibabaModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class ChallengeController extends ResourceController
{
    use ResponseTrait;

    protected $db;
    protected $table            = 'challenge_alibaba';
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
        $ChallengeAlibabaModel = new ChallengeAlibabaModel();

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
            'source'   => 'genai',
        ]);

        // if failed insert users
        if (! $userId) {
            return $this->fail(['status' => 'failed', 'message' => 'Registrasi gagal.']);
        }

        $data['user_id']       = $userId;
        $data['whatsapp']      = $number;
        $data['status']        = 'terdaftar';

        // Check existing by user_id before insert
        $participant = $ChallengeAlibabaModel->where('user_id', $userId)->where('deleted_at', null)->first();

        if ($participant) {
            return $this->fail(['status' => 'failed', 'message' => 'Akun lomba sudah pernah terdaftar.']);
        }

        // Prepare accept flags and payload with only allowed fields
        $data['accept_terms']     = ! empty($data['accept_terms']) ? $data['accept_terms'] : 0;
        $data['accept_agreement'] = ! empty($data['accept_agreement']) ? $data['accept_agreement'] : 0;

        $payload = [
            'user_id'         => $userId,
            'fullname'        => $data['fullname'],
            'email'           => strtolower($data['email']),
            'whatsapp'        => $number,
            'accept_terms'    => $data['accept_terms'],
            'accept_agreement'=> $data['accept_agreement'],
        ];

        $insertId = $ChallengeAlibabaModel->insert($payload);
        if (! $insertId) {
            return $this->fail(['status' => 'failed', 'message' => 'Registrasi lomba gagal.']);
        }

        // Insert profile fields to user_profiles via UserProfile model
        $UserProfileModel = new \App\Models\UserProfile();

        $profilePayload = [
            'user_id' => $userId,
        ];

        $profileFields = [
            'birthday', 'gender', 'province', 'city', 'occupation', 'work_experience', 'skill', 'institution', 'major',
            'semester', 'grade', 'type_of_business', 'business_duration', 'education_level', 'graduation_year', 'link_business', 'last_project'
        ];

        foreach ($profileFields as $field) {
            if (isset($data[$field]) && $data[$field] !== '') {
                $profilePayload[$field] = $data[$field];
            }
        }

        $profileInsert = $UserProfileModel->insert($profilePayload);
        if (! $profileInsert) {
            // rollback created challenge participant and user to avoid partial data
            $ChallengeAlibabaModel->delete($insertId);
            $userModel->delete($userId);

            return $this->fail(['status' => 'failed', 'message' => 'Registrasi gagal (profil).']);
        }

        // Jwt only email, whatsapp_number, user_id
        $jwt = JWT::encode([
            'email'           => strtolower($data['email']),
            'whatsapp_number' => $number,
            'user_id'         => $userId,
        ], config('Heroic')->jwtKey['secret'], 'HS256');

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Registrasi akun lomba berhasil.',
            'token'   => $jwt,
        ]);
    }

    public function statistics()
    {
        $ChallengeAlibabaModel = new ChallengeAlibabaModel();

        $totalParticipants = $ChallengeAlibabaModel->where('deleted_at', null)->countAllResults();
        $totalSubmitted = $ChallengeAlibabaModel
                        ->where('twitter_post_url IS NOT NULL')
                        ->where('twitter_post_url !=', '')
                        ->where('deleted_at IS NULL')
                        ->countAllResults();

        return $this->respond([
            'status'             => 'success',
            'total_participants' => $totalParticipants,
            'total_submitted'    => $totalSubmitted,
        ]);
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
}
