<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpRequests extends Model
{
    protected $table          = 'otp_requests';
    protected $primaryKey     = 'id';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ['otp_code', 'identity', 'type', 'expired_at', 'reminded', 'created_at', 'updated_at', 'deleted_at'];
}
