<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class SubmissionModel extends Model
{
    protected $table            = 'cls_submissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'progress_id',
        'type',
        'file_path',
        'file_name',
        'file_size',
        'url',
        'submitted_at',
        'reviewed_by',
        'reviewed_at',
        'review_score',
        'review_note',
        'status',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;

    public function forProgress(int $progressId): ?array
    {
        return $this->where('progress_id', $progressId)
            ->orderBy('submitted_at', 'DESC')
            ->first() ?: null;
    }

    /**
     * List submission untuk sebuah materi kelas, dengan info user & resource.
     */
    public function forClassMaterial(int $classMaterialId): array
    {
        $builder = $this->db->table('cls_submissions s')
            ->select('s.*, u.name AS user_name, u.email AS user_email, r.title AS resource_title')
            ->join('cls_learning_progress p', 'p.id = s.progress_id')
            ->join('cls_learning_resources r', 'r.id = p.resource_id', 'left')
            ->join('mein_users u', 'u.id = p.user_id', 'left')
            ->where('p.class_material_id', $classMaterialId);

        return $builder->orderBy('s.submitted_at', 'DESC')->get()->getResultArray();
    }

    public function review(int $id, string $status, ?float $score = null, ?string $note = null, ?int $reviewedBy = null): void
    {
        $this->update($id, [
            'status'       => $status,
            'review_score' => $score,
            'review_note'  => $note,
            'reviewed_by'  => $reviewedBy,
            'reviewed_at'  => date('Y-m-d H:i:s'),
        ]);
    }
}
