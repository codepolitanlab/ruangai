<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class LearningProgressModel extends Model
{
    protected $table            = 'cls_learning_progress';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'class_material_id',
        'resource_id',
        'user_id',
        'status',
        'completed_at',
        'meta',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function findFor(int $classMaterialId, int $resourceId, int $userId): ?array
    {
        $row = $this->where('class_material_id', $classMaterialId)
            ->where('resource_id', $resourceId)
            ->where('user_id', $userId)
            ->get()->getRowArray();

        return $row ?: null;
    }

    public function upsertStatus(int $classMaterialId, int $resourceId, int $userId, string $status, ?array $meta = null): void
    {
        $existing = $this->findFor($classMaterialId, $resourceId, $userId);

        $data = [
            'class_material_id' => $classMaterialId,
            'resource_id'       => $resourceId,
            'user_id'           => $userId,
            'status'            => $status,
            'completed_at'      => $status === 'completed' ? date('Y-m-d H:i:s') : null,
            'meta'              => $meta !== null ? json_encode($meta) : null,
        ];

        if ($existing) {
            $data['completed_at'] = $status === 'completed'
                ? ($existing['completed_at'] ?: date('Y-m-d H:i:s'))
                : $existing['completed_at'];
            $this->update($existing['id'], $data);
        } else {
            $this->insert($data);
        }
    }

    /**
     * Persentase progres: completed resource wajib / total resource wajib.
     */
    public function materialProgressPercent(int $classMaterialId, int $userId): float
    {
        $db = $this->db;

        $required = $db->table('cls_learning_resources r')
            ->join('cls_class_materials cm', 'cm.material_id = r.material_id')
            ->where('cm.id', $classMaterialId)
            ->where('r.is_required', 1)
            ->where('r.deleted_at IS NULL')
            ->countAllResults();

        if ($required === 0) {
            return 0;
        }

        $completed = $this->where('class_material_id', $classMaterialId)
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->countAllResults();

        return round(($completed / $required) * 100, 2);
    }
}
