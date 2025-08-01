<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpWhatsappModel extends Model
{
    protected $table         = 'otp_whatsapps';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['otp_code', 'whatsapp_number', 'expired_at', 'created_at'];
    public $timestamps       = true;
    protected $createdField  = 'created_at';
}
