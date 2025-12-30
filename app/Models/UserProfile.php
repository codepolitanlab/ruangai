<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProfile extends Model
{
    protected $table         = 'user_profiles';
    protected $primaryKey    = 'id';

    protected $allowedFields = [
        'user_id',
        'bank_name',
        'account_number',
        'account_name',
        'account_valid',
        'identity_card_image',
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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $useTimestamps = true;
}
