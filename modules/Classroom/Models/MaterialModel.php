<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table            = 'cls_materials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'syllabus_id',
        'title',
        'subtitle',
        'description',
        'order_seq',
        'weight',
        'scoring_type',
        'deleted_at',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'title' => 'required|max_length[255]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Materi beserta resource-nya (terstruktur).
     */
    public function withResources(int $syllabusId): array
    {
        $materials = $this->where('syllabus_id', $syllabusId)
            ->orderBy('order_seq', 'ASC')
            ->findAll();

        $resourceModel = new LearningResourceModel();

        foreach ($materials as &$material) {
            $material['resources'] = $resourceModel
                ->where('material_id', $material['id'])
                ->orderBy('order_seq', 'ASC')
                ->findAll();
        }

        return $materials;
    }

    /**
     * Urutan berikutnya (order_seq) untuk materi baru dalam silabus.
     */
    public function nextOrder(int $syllabusId): int
    {
        return (int) $this->where('syllabus_id', $syllabusId)
            ->selectMax('order_seq')
            ->get()
            ->getRow()->order_seq + 1;
    }
}
