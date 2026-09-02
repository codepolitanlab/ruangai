<?php

namespace App\Pages\bootcamp\intro;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Intro Bootcamp',
        'module'     => 'bootcamp',
        'active_page' => 'bootcamp',
        'body_class' => 'rd-dashboard-page',
    ];

    /**
     * GET /bootcamp/intro/data/{class_id} — ringkasan kelas sebelum belajar.
     */
    public function getData($classId)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;
        $classId = (int) $classId;

        $class = $db->table('cls_classes')
            ->where('id', $classId)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $class) {
            return $this->respondSecure(['status' => 'error', 'message' => 'Kelas tidak ditemukan.'], 404);
        }

        if (! $this->isMember($db, $classId, $userId)) {
            return $this->respondSecure(['status' => 'error', 'message' => 'Anda belum terdaftar di kelas ini.'], 403);
        }

        $syllabus = $db->table('cls_syllabuses')
            ->where('id', $class['syllabus_id'])
            ->get()
            ->getRowArray();

        // Daftar materi kelas + progres user
        $cms = $db->table('cls_class_materials cm')
            ->select('cm.*, m.title AS material_title, m.subtitle AS material_subtitle, m.description AS material_description, m.order_seq AS material_order_seq')
            ->join('cls_materials m', 'm.id = cm.material_id', 'left')
            ->where('cm.class_id', $classId)
            ->orderBy('m.order_seq', 'ASC')
            ->get()
            ->getResultArray();

        $totalRequired = 0;
        $totalCompleted = 0;
        $firstUnfinished = null;

        foreach ($cms as &$cm) {
            $cm['is_open'] = (int) $cm['is_open'];

            $required = $db->table('cls_learning_resources r')
                ->join('cls_class_materials cm2', 'cm2.material_id = r.material_id')
                ->where('cm2.id', $cm['id'])
                ->where('r.is_required', 1)
                ->where('r.deleted_at IS NULL')
                ->countAllResults();

            // Hanya resource WAJIB yang selesai (konsisten dgn halaman belajar)
            $completed = $db->table('cls_learning_resources r')
                ->join('cls_learning_progress p', 'p.resource_id = r.id AND p.class_material_id = ' . $cm['id'] . ' AND p.user_id = ' . $userId)
                ->where('r.material_id', $cm['material_id'])
                ->where('r.is_required', 1)
                ->where('r.deleted_at IS NULL')
                ->where('p.status', 'completed')
                ->countAllResults();

            $cm['required_count']  = $required;
            $cm['completed_count'] = $completed;
            $cm['progress_percent'] = $required > 0 ? (int) round(($completed / $required) * 100) : 0;

            $totalRequired  += $required;
            $totalCompleted += $completed;

            if ($firstUnfinished === null && $cm['progress_percent'] < 100) {
                $firstUnfinished = $cm;
            }
        }
        unset($cm);

        $this->data['class']            = $class;
        $this->data['syllabus']         = $syllabus ?: null;
        $this->data['materials']        = $cms;
        $this->data['total_required']   = $totalRequired;
        $this->data['total_completed']  = $totalCompleted;
        $this->data['progress_percent'] = $totalRequired > 0 ? (int) round(($totalCompleted / $totalRequired) * 100) : 0;
        $this->data['first_unfinished'] = $firstUnfinished;

        return $this->respondSecure($this->data);
    }

    private function isMember($db, int $classId, int $userId): bool
    {
        return $db->table('cls_class_members')
            ->where('class_id', $classId)
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->countAllResults() > 0;
    }
}
