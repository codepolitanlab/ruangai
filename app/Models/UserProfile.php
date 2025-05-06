<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'bank_name', 'bank_account', 'bank_code', 'created_at', 'updated_at', 'deleted_at'];
    protected $useTimestamps = true;
}
