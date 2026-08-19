<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class ClassRoomModel extends Model
{
    protected $table            = 'cls_classes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'syllabus_id',
        'name',
        'thumbnail',
        'description',
        'status',
        'start_date',
        'whatsapp_group_url',
        'certificate_requirement',
        'required_feedback_before_claim_certificate',
        'certificate_claimable',
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

    protected $validationRules = [
        'syllabus_id' => 'required|is_natural_no_zero',
        'name'        => 'required|max_length[255]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    public function withSyllabus(array $where = [], ?string $search = null): array
    {
        $builder = $this->db->table('cls_classes c')
            ->select('c.*, s.name AS syllabus_name')
            ->join('cls_syllabuses s', 's.id = c.syllabus_id', 'left')
            ->where('c.deleted_at IS NULL');

        if (! empty($where)) {
            $builder->where($where);
        }

        if ($search) {
            $builder->groupStart()
                ->like('c.name', $search)
                ->orLike('s.name', $search)
                ->groupEnd();
        }

        return $builder->orderBy('c.created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Hitung jumlah peserta aktif per kelas.
     */
    public function memberCount(int $classId): int
    {
        return $this->db->table('cls_class_members')
            ->where('class_id', $classId)
            ->where('status', 'active')
            ->countAllResults();
    }
}
