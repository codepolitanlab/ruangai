<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class SyllabusModel extends Model
{
    protected $table            = 'cls_syllabuses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'subtitle',
        'description',
        'status',
        'created_by',
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

    protected $validationRules    = [
        'name' => 'required|max_length[255]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Ambil silabus beserta jumlah materi (termasuk yang soft-deleted dihitung 0).
     */
    public function withMaterialCount(array $where = [], ?string $search = null)
    {
        $builder = $this->db->table('cls_syllabuses s')
            ->select('s.*, COUNT(m.id) AS material_count')
            ->join('cls_materials m', 'm.syllabus_id = s.id AND m.deleted_at IS NULL', 'left')
            ->where('s.deleted_at IS NULL')
            ->groupBy('s.id');

        if (! empty($where)) {
            $builder->where($where);
        }

        if ($search) {
            $builder->groupStart()
                ->like('s.name', $search)
                ->orLike('s.subtitle', $search)
                ->groupEnd();
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Cek apakah silabus dipakai kelas berstatus active (untuk blokir delete).
     */
    public function isUsedByActiveClass(int $syllabusId): bool
    {
        return $this->db->table('cls_classes')
            ->where('syllabus_id', $syllabusId)
            ->where('status', 'active')
            ->where('deleted_at IS NULL')
            ->countAllResults() > 0;
    }

    public function duplicateWithContent(int $syllabusId): ?int
    {
        $syllabus = $this->find($syllabusId);
        if (! $syllabus) {
            return null;
        }

        $db = $this->db;
        $db->transBegin();

        try {
            unset($syllabus['id'], $syllabus['created_at'], $syllabus['updated_at'], $syllabus['deleted_at']);
            $syllabus['status'] = 'draft';
            $syllabus['name']   = $syllabus['name'] . ' (Salinan)';

            $newSyllabusId = $this->insert($syllabus);

            // Deep copy materi + resource
            $materials = $db->table('cls_materials')
                ->where('syllabus_id', $syllabusId)
                ->where('deleted_at IS NULL')
                ->orderBy('order_seq', 'ASC')
                ->get()->getResultArray();

            foreach ($materials as $material) {
                unset($material['id'], $material['deleted_at']);
                $material['syllabus_id'] = $newSyllabusId;
                $db->table('cls_materials')->insert($material);
                $newMaterialId = $db->insertID();

                $resources = $db->table('cls_learning_resources')
                    ->where('material_id', $material['id'])
                    ->where('deleted_at IS NULL')
                    ->orderBy('order_seq', 'ASC')
                    ->get()->getResultArray();

                foreach ($resources as $resource) {
                    unset($resource['id'], $resource['deleted_at']);
                    $resource['material_id'] = $newMaterialId;
                    $db->table('cls_learning_resources')->insert($resource);
                }
            }

            $db->transCommit();

            return $newSyllabusId;
        } catch (\Throwable $e) {
            $db->transRollback();
            throw $e;
        }
    }
}
