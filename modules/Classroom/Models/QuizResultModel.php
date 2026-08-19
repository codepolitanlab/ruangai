<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class QuizResultModel extends Model
{
    protected $table            = 'cls_quiz_results';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'progress_id',
        'answers',
        'score',
        'max_score',
        'passed',
        'attempt_number',
        'submitted_at',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;

    public function forProgress(int $progressId): array
    {
        return $this->where('progress_id', $progressId)
            ->orderBy('attempt_number', 'DESC')
            ->findAll();
    }

    public function nextAttemptNumber(int $progressId): int
    {
        $last = $this->where('progress_id', $progressId)
            ->orderBy('attempt_number', 'DESC')
            ->first();

        return $last ? (int) $last['attempt_number'] + 1 : 1;
    }
}
