<?php

namespace Webhook\Models;

use CodeIgniter\Model;

class WebhookLogModel extends Model
{
    protected $table          = 'webhook_logs';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields  = [
        'source_id',
        'source_slug',
        'event',
        'method',
        'headers',
        'payload',
        'ip_address',
        'status',
        'error_message',
        'response_status',
        'processed_at',
        'is_reviewed',
        'reviewed_at',
        'reviewed_by',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
