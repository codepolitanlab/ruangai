<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class QuizQuestionModel extends Model
{
    protected $table            = 'cls_quiz_questions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'resource_id',
        'question',
        'type',
        'options',
        'correct_answer',
        'score',
        'order_seq',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;

    public function forResource(int $resourceId): array
    {
        return $this->where('resource_id', $resourceId)
            ->orderBy('order_seq', 'ASC')
            ->findAll();
    }

    public function totalScore(int $resourceId): int
    {
        $row = $this->where('resource_id', $resourceId)
            ->selectSum('score')
            ->get()
            ->getRowArray();

        return (int) ($row['score'] ?? 0);
    }

    public static function decodeOptions(?string $options): array
    {
        if (! $options) {
            return [];
        }

        $decoded = json_decode($options, true);

        return is_array($decoded) ? $decoded : [];
    }
}
