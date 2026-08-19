<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $table            = 'cls_feedbacks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'class_id',
        'user_id',
        'profession',
        'city',
        'condition_before',
        'condition_before_other',
        'reason_choice',
        'favorite_moment',
        'rating',
        'concrete_skill',
        'message_to_friend',
        'allow_testimonial',
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

    public const CONDITION_BEFORE_LABELS = [
        'a' => 'Belum pernah ngoding',
        'b' => 'Pernah coba, tapi berhenti',
        'c' => 'Bisa dasar HTML/CSS',
        'd' => 'Bisa front-end, ingin back-end',
        'e' => 'Bekerja di bidang IT, ingin upgrade',
        'f' => 'Lainnya',
    ];

    public function forClassWithUsers(int $classId): array
    {
        return $this->db->table('cls_feedbacks f')
            ->select('f.*, u.name AS user_name, u.email AS user_email, u.phone')
            ->join('mein_users u', 'u.id = f.user_id', 'left')
            ->where('f.class_id', $classId)
            ->where('f.deleted_at IS NULL')
            ->orderBy('f.created_at', 'DESC')
            ->get()->getResultArray();
    }
}
