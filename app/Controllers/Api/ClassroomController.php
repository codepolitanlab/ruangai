<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class ClassroomController extends ResourceController
{
    use ResponseTrait;

    protected $db;
    protected $format = 'json';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Jadwal materi terdekat dari kelas bootcamp berstatus active.
     * Query: class_id (opsional), limit (default 5, maks 50).
     */
    public function schedule()
    {
        $limit   = (int) ($this->request->getGet('limit') ?: 5);
        $limit   = max(1, min(50, $limit));
        $classId = (int) $this->request->getGet('class_id');

        $builder = $this->db->table('cls_class_materials cm')
            ->select('c.name AS class_name, c.thumbnail AS class_thumbnail, c.checkout_url AS class_checkout_url, s.name AS syllabus_name, m.title AS material_title, m.subtitle AS material_subtitle, cm.scheduled_at')
            ->join('cls_classes c', 'c.id = cm.class_id')
            ->join('cls_materials m', 'm.id = cm.material_id')
            ->join('cls_syllabuses s', 's.id = c.syllabus_id', 'left')
            ->where('c.status', 'active')
            ->where('c.deleted_at IS NULL')
            ->where('m.deleted_at IS NULL')
            ->where('m.syllabus_id = c.syllabus_id', null, false)
            ->where('cm.scheduled_at IS NOT NULL')
            ->where('cm.scheduled_at >=', date('Y-m-d H:i:s'));

        if ($classId > 0) {
            $builder->where('cm.class_id', $classId);
        }

        $rows = $builder->orderBy('cm.scheduled_at', 'ASC')
            ->limit($limit)
            ->get()
            ->getResultArray();

        return $this->respond([
            'status' => 'success',
            'data'   => $rows,
        ]);
    }
}
