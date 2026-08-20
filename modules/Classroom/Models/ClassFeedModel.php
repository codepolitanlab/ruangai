<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class ClassFeedModel extends Model
{
    protected $table            = 'cls_class_feeds';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'class_id',
        'title',
        'body',
        'pinned',
        'created_by',
        'created_at',
        'updated_at',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function forClass(int $classId, bool $pinnedFirst = true): array
    {
        $builder = $this->where('class_id', $classId);

        if ($pinnedFirst) {
            $builder->orderBy('pinned', 'DESC')->orderBy('created_at', 'DESC');
        } else {
            $builder->orderBy('created_at', 'DESC');
        }

        return $builder->findAll();
    }

    public function togglePin(int $id): void
    {
        $feed = $this->find($id);
        if ($feed) {
            $this->update($id, ['pinned' => $feed['pinned'] ? 0 : 1]);
        }
    }
}
