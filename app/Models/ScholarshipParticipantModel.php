<?php

namespace App\Models;

use CodeIgniter\Model;

class ScholarshipParticipantModel extends Model
{
    protected $table = 'scholarship_participants';
    protected $allowedFields = [
        'user_id', 'fullname', 'email', 'whatsapp', 'date_of_birth',
        'gender', 'province', 'city', 'occupation', 'work_experience',
        'skill', 'institution', 'major', 'semester', 'grade',
        'type_of_business', 'business_duration', 'reference', 'program', 'referral_code'
    ];
    protected $useTimestamps = true;
}