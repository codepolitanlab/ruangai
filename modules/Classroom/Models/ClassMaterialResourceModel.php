<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class ClassMaterialResourceModel extends Model
{
    protected $table            = 'cls_class_material_resources';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'class_id',
        'material_id',
        'resource_id',
        'metadata',
        'created_at',
        'updated_at',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function forClassMaterial(int $classId, int $materialId): array
    {
        return $this->where('class_id', $classId)
            ->where('material_id', $materialId)
            ->findAll();
    }

    public function metadataFor(int $classId, int $materialId, int $resourceId): array
    {
        $row = $this->where('class_id', $classId)
            ->where('material_id', $materialId)
            ->where('resource_id', $resourceId)
            ->get()->getRowArray();

        if (! $row || empty($row['metadata'])) {
            return [];
        }

        $decoded = json_decode($row['metadata'], true);

        return is_array($decoded) ? $decoded : [];
    }

    public function upsertMetadata(int $classId, int $materialId, int $resourceId, array $metadata): void
    {
        $existing = $this->where('class_id', $classId)
            ->where('material_id', $materialId)
            ->where('resource_id', $resourceId)
            ->get()->getRowArray();

        $data = [
            'class_id'    => $classId,
            'material_id' => $materialId,
            'resource_id' => $resourceId,
            'metadata'    => json_encode($metadata, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ];

        if ($existing) {
            $this->update($existing['id'], $data);
        } else {
            $this->insert($data);
        }
    }
}
