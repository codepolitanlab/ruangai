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

    /**
     * Duplikasi kelas: salinan baris kelas + jadwal materi (cls_class_materials)
     * + metadata resource (cls_class_material_resources).
     * Data peserta & aktivitas (members, progress, submission, feed, notifikasi,
     * feedback, nilai) TIDAK disalin — salinan dipakai sebagai kerangka batch baru.
     */
    public function duplicateWithSchedule(int $classId, ?int $createdBy = null): ?int
    {
        $class = $this->find($classId);
        if (! $class) {
            return null;
        }

        $db = $this->db;
        $db->transBegin();

        try {
            unset($class['id'], $class['created_at'], $class['updated_at'], $class['deleted_at']);
            $class['name']   = $class['name'] . ' (Salinan)';
            $class['status'] = 'draft'; // salinan wajib ditinjau ulang sebelum diaktifkan
            if ($createdBy !== null) {
                $class['created_by'] = $createdBy;
            }

            $newClassId = $this->insert($class);

            if (! $newClassId) {
                throw new \RuntimeException('Gagal menyimpan salinan kelas');
            }

            // Jadwal materi ikut tersalin (tanggal, catatan, info meeting), tapi status
            // buka direset supaya admin membuka materi sesuai jadwal baru.
            // Catatan: cls_class_materials / cls_class_material_resources tidak punya deleted_at.
            $schedules = $db->table('cls_class_materials')
                ->where('class_id', $classId)
                ->get()->getResultArray();

            foreach ($schedules as $schedule) {
                unset($schedule['id'], $schedule['created_at'], $schedule['updated_at'], $schedule['deleted_at']);
                $schedule['class_id']  = $newClassId;
                $schedule['is_open']   = 0;
                $schedule['opened_at'] = null;
                $db->table('cls_class_materials')->insert($schedule);
            }

            $metadata = $db->table('cls_class_material_resources')
                ->where('class_id', $classId)
                ->get()->getResultArray();

            foreach ($metadata as $meta) {
                unset($meta['id'], $meta['created_at'], $meta['updated_at'], $meta['deleted_at']);
                $meta['class_id'] = $newClassId;
                $db->table('cls_class_material_resources')->insert($meta);
            }

            $db->transCommit();

            return $newClassId;
        } catch (\Throwable $e) {
            $db->transRollback();
            throw $e;
        }
    }
}
