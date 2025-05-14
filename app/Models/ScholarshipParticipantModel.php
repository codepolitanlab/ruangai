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
        'type_of_business', 'business_duration', 'education_level', 'graduation_year', 'link_business', 'last_project', 'reference', 'program', 'referral_code', 'accept_terms', 'accept_agreement', 'withdrawal', 'status'
    ];
    protected $useTimestamps = true;
}