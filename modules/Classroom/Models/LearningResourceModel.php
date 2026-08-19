<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class LearningResourceModel extends Model
{
    protected $table            = 'cls_learning_resources';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'material_id',
        'type',
        'title',
        'content',
        'order_seq',
        'completion_criteria',
        'is_required',
        'need_review',
        'deleted_at',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'title' => 'required|max_length[255]',
        'type'  => 'required|max_length[50]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    public const TYPES = [
        'text',
        'video',
        'pdf',
        'slide',
        'audio',
        'url',
        'book_ref',
        'quiz',
        'submission',
        'meeting',
    ];

    public const COMPLETION_CRITERIA = [
        'view',
        'submit',
        'score_pass',
    ];

    public function nextOrder(int $materialId): int
    {
        return (int) $this->where('material_id', $materialId)
            ->selectMax('order_seq')
            ->get()
            ->getRow()->order_seq + 1;
    }

    /**
     * Decode kolom content (JSON) menjadi array; jika bukan JSON valid, kembalikan kosong.
     */
    public static function decodeContent(?string $content): array
    {
        if (! $content) {
            return [];
        }

        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : [];
    }

    public static function encodeContent(array $data): string
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
