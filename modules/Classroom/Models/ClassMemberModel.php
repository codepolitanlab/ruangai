<?php

namespace Classroom\Models;

use CodeIgniter\Model;

class ClassMemberModel extends Model
{
    protected $table            = 'cls_class_members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'class_id',
        'user_id',
        'role',
        'enrolled_at',
        'status',
        'final_score',
    ];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';

    protected $validationRules = [
        'class_id' => 'required|is_natural_no_zero',
        'user_id'  => 'required|is_natural_no_zero',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    /**
     * Peserta dengan info user (nama, email, dll.).
     * Kolom user diambil dari tabel mein_users sesuai konvensi aplikasi.
     */
    public function forClassWithUsers(int $classId, ?string $status = null): array
    {
        $builder = $this->db->table('cls_class_members cm')
            ->select('cm.*, u.name AS user_name, u.username, u.email, u.phone, u.avatar')
            ->join('mein_users u', 'u.id = cm.user_id', 'left')
            ->where('cm.class_id', $classId);

        if ($status) {
            $builder->where('cm.status', $status);
        }

        return $builder->orderBy('cm.role', 'ASC')->orderBy('u.name', 'ASC')->get()->getResultArray();
    }

    public function findActive(int $classId, int $userId): ?array
    {
        $row = $this->where('class_id', $classId)
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->get()->getRowArray();

        return $row ?: null;
    }

    /**
     * Cari user di tabel mein_users (exclude yang sudah jadi member kelas).
     */
    public function searchUsers(int $classId, string $query, int $limit = 20): array
    {
        $db = $this->db;

        $excluded = $db->table('cls_class_members')
            ->where('class_id', $classId)
            ->where('status', 'active')
            ->get()->getResultArray();
        $excludedIds = array_column($excluded, 'user_id');

        $builder = $db->table('mein_users')
            ->select('id, name, username, email, phone')
            ->groupStart()
            ->like('name', $query)
            ->orLike('username', $query)
            ->orLike('email', $query)
            ->orLike('phone', $query)
            ->groupEnd();

        if (! empty($excludedIds)) {
            $builder->whereNotIn('id', $excludedIds);
        }

        return $builder->limit($limit)->get()->getResultArray();
    }

    /**
     * Cari user berdasarkan email/username/phone untuk import CSV.
     */
    public function findUserByIdentifier(string $identifier): ?array
    {
        $db = $this->db;

        $row = $db->table('mein_users')
            ->select('id, name, username, email, phone')
            ->groupStart()
            ->where('email', $identifier)
            ->orWhere('username', $identifier)
            ->orWhere('phone', $identifier)
            ->groupEnd()
            ->get()->getRowArray();

        return $row ?: null;
    }

    public function addOrReactivate(int $classId, int $userId, string $role = 'member'): string
    {
        $existing = $this->where('class_id', $classId)
            ->where('user_id', $userId)
            ->get()->getRowArray();

        if ($existing) {
            if ($existing['status'] === 'dropped') {
                $this->update($existing['id'], ['status' => 'active']);
            }

            return 'reactivated';
        }

        $this->insert([
            'class_id'    => $classId,
            'user_id'     => $userId,
            'role'        => $role,
            'enrolled_at' => date('Y-m-d H:i:s'),
            'status'      => 'active',
        ]);

        return 'added';
    }
}
