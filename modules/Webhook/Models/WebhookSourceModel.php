<?php

namespace Webhook\Models;

use CodeIgniter\Model;

class WebhookSourceModel extends Model
{
    protected $table          = 'webhook_sources';
    protected $primaryKey     = 'id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields  = [
        'name',
        'slug',
        'secret',
        'header_name',
        'handler',
        'status',
        'description',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Cari sumber webhook yang masih aktif berdasarkan slug.
     */
    public function findActiveBySlug(string $slug): ?array
    {
        return $this->where('slug', $slug)->where('status', 'active')->first();
    }
}
