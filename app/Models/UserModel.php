<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'username', 'email', 'phone', 'last_active', 'phone_valid', 'email_valid'];
    protected $useTimestamps = true;
}