<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'cls_notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'type',
        'title',
        'body',
        'read_at',
        'meta',
        'created_at',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;

    public function forUser(int $userId, int $limit = 50): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function unreadCount(int $userId): int
    {
        return $this->where('user_id', $userId)
            ->where('read_at IS NULL')
            ->countAllResults();
    }

    public function markAllRead(int $userId): void
    {
        $this->where('user_id', $userId)
            ->where('read_at IS NULL')
            ->set('read_at', date('Y-m-d H:i:s'))
            ->update();
    }
}
