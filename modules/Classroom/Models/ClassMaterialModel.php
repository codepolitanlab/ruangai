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
            ->join('cls_classes c', 'c.id = cm.class_id', 'left')
            ->where('cm.class_id', $classId)
            // Hanya materi milik silabus kelas ini. Pivot sisa silabus lain (mis. kelas hasil
            // duplikasi sebelum silabusnya diganti) tidak ikut tampil sebagai baris ganda.
            ->where('m.syllabus_id = c.syllabus_id', null, false);

        if ($onlySynced) {
            $builder->where('m.deleted_at IS NULL');
        }

        return $builder->orderBy('m.order_seq', 'ASC')->get()->getResultArray();
    }

    /**
     * Satu baris class_material beserta info materi (LEFT JOIN), untuk dipakai
     * halaman yang menampilkan judul materi (mis. progress/quiz/submission).
     */
    public function findWithMaterial(int $id): ?array
    {
        $row = $this->db->table('cls_class_materials cm')
            ->select('cm.*, m.title AS material_title, m.subtitle AS material_subtitle, m.description AS material_description, m.order_seq AS material_order_seq')
            ->join('cls_materials m', 'm.id = cm.material_id', 'left')
            ->where('cm.id', $id)
            ->get()->getRowArray();

        return $row ?: null;
    }

    /**
     * Samakan jadwal kelas dengan materi silabusnya.
     *  - materi silabus yang belum punya pivot ditambahkan (is_open = 0)
     *  - pivot untuk materi yang tidak lagi ada di silabus (atau sudah dihapus) dibuang,
     *    KECUALI pivot yang sudah punya data peserta (progres / nilai) — dibiarkan agar
     *    data peserta tidak hilang, dan jumlahnya dilaporkan ke pemanggil.
     *
     * @return array{created:int, removed:int, kept:int}
     */
    public function syncFromSyllabus(int $classId, int $syllabusId): array
    {
        $db = $this->db;

        $materials = $db->table('cls_materials')
            ->select('id')
            ->where('syllabus_id', $syllabusId)
            ->where('deleted_at IS NULL')
            ->get()->getResultArray();

        $syllabusMaterialIds = array_map('intval', array_column($materials, 'id'));

        $pivots = $db->table('cls_class_materials')
            ->where('class_id', $classId)
            ->get()->getResultArray();

        $existingMaterialIds = array_map('intval', array_column($pivots, 'material_id'));

        // 1. Tambah pivot untuk materi silabus yang belum terjadwal
        $created = 0;
        foreach ($syllabusMaterialIds as $materialId) {
            if (in_array($materialId, $existingMaterialIds, true)) {
                continue;
            }

            $db->table('cls_class_materials')->insert([
                'class_id'    => $classId,
                'material_id' => $materialId,
                'is_open'     => 0,
            ]);
            $created++;
        }

        // 2. Buang pivot untuk materi yang bukan bagian silabus kelas ini
        $removed = 0;
        $kept    = 0;
        foreach ($pivots as $pivot) {
            if (in_array((int) $pivot['material_id'], $syllabusMaterialIds, true)) {
                continue;
            }

            $hasParticipantData = $db->table('cls_learning_progress')
                ->where('class_material_id', $pivot['id'])
                ->countAllResults() > 0
                || $db->table('cls_member_scores')
                    ->where('class_material_id', $pivot['id'])
                    ->countAllResults() > 0;

            if ($hasParticipantData) {
                $kept++;
                continue;
            }

            $db->table('cls_class_material_resources')
                ->where('class_id', $classId)
                ->where('material_id', $pivot['material_id'])
                ->delete();
            $db->table('cls_class_materials')->where('id', $pivot['id'])->delete();
            $removed++;
        }

        return ['created' => $created, 'removed' => $removed, 'kept' => $kept];
    }
}
