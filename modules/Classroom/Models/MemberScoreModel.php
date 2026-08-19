<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class MemberScoreModel extends Model
{
    protected $table            = 'cls_member_scores';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'class_material_id',
        'user_id',
        'raw_score',
        'final_score',
        'scoring_type',
        'scored_by',
        'scored_at',
        'notes',
        'status',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;

    public function findFor(int $classMaterialId, int $userId): ?array
    {
        return $this->where('class_material_id', $classMaterialId)
            ->where('user_id', $userId)
            ->first() ?: null;
    }

    public function upsert(int $classMaterialId, int $userId, array $data): void
    {
        $existing = $this->findFor($classMaterialId, $userId);
        $data['class_material_id'] = $classMaterialId;
        $data['user_id']           = $userId;

        if ($existing) {
            $this->update($existing['id'], $data);
        } else {
            $this->insert($data);
        }
    }
}
