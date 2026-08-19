<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class MemberWorkModel extends Model
{
    protected $table            = 'cls_member_works';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'title',
        'thumbnail',
        'photos',
        'description',
        'short_description',
        'status',
        'url_project',
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
        'title' => 'required|max_length[255]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    public function withUser(array $where = [], ?string $search = null, ?string $status = null): array
    {
        $builder = $this->db->table('cls_member_works w')
            ->select('w.*, u.name AS user_name, u.email AS user_email')
            ->join('mein_users u', 'u.id = w.user_id', 'left')
            ->where('w.deleted_at IS NULL');

        if (! empty($where)) {
            $builder->where($where);
        }

        if ($status) {
            $builder->where('w.status', $status);
        }

        if ($search) {
            $builder->groupStart()
                ->like('w.title', $search)
                ->orLike('w.short_description', $search)
                ->orLike('u.name', $search)
                ->groupEnd();
        }

        return $builder->orderBy('w.created_at', 'DESC')->get()->getResultArray();
    }

    public function findWithUser(int $id): ?array
    {
        $row = $this->db->table('cls_member_works w')
            ->select('w.*, u.name AS user_name, u.email AS user_email')
            ->join('mein_users u', 'u.id = w.user_id', 'left')
            ->where('w.id', $id)
            ->where('w.deleted_at IS NULL')
            ->get()->getRowArray();

        return $row ?: null;
    }

    public static function decodePhotos(?string $photos): array
    {
        if (! $photos) {
            return [];
        }

        $decoded = json_decode($photos, true);

        return is_array($decoded) ? $decoded : [];
    }
}
