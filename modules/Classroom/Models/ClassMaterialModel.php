<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class ClassMaterialModel extends Model
{
    protected $table            = 'cls_class_materials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'class_id',
        'material_id',
        'instructor_id',
        'scheduled_at',
        'is_open',
        'opened_at',
        'notes',
        'meeting_info',
        'created_at',
        'updated_at',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Daftar class_materials untuk sebuah kelas, dengan info materi (LEFT JOIN),
     * termasuk yang belum ter-sync (is_unsynced = true ketika material tidak ada pivot).
     */
    public function forClassWithMaterials(int $classId, bool $onlySynced = true): array
    {
        $builder = $this->db->table('cls_class_materials cm')
            ->select('cm.*, m.title AS material_title, m.subtitle AS material_subtitle, m.description AS material_description, m.order_seq AS material_order_seq')
            ->join('cls_materials m', 'm.id = cm.material_id', 'left')
            ->where('cm.class_id', $classId);

        if ($onlySynced) {
            $builder->where('m.deleted_at IS NULL');
        }

        return $builder->orderBy('m.order_seq', 'ASC')->get()->getResultArray();
    }

    /**
     * Auto-generate class_materials untuk tiap materi silabus yang belum ada pivot-nya.
     * Mengembalikan jumlah yang baru dibuat.
     */
    public function syncFromSyllabus(int $classId, int $syllabusId): int
    {
        $db = $this->db;

        $existing = $db->table('cls_class_materials')
            ->where('class_id', $classId)
            ->get()->getResultArray();

        $existingMaterialIds = array_column($existing, 'material_id');

        $materials = $db->table('cls_materials')
            ->where('syllabus_id', $syllabusId)
            ->where('deleted_at IS NULL')
            ->get()->getResultArray();

        $created = 0;
        foreach ($materials as $material) {
            if (in_array($material['id'], $existingMaterialIds, true)) {
                continue;
            }

            $db->table('cls_class_materials')->insert([
                'class_id'    => $classId,
                'material_id' => $material['id'],
                'is_open'     => 0,
            ]);
            $created++;
        }

        return $created;
    }
}
