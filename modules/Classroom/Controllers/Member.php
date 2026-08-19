<?php

namespace Classroom\Controllers;

use Classroom\Models\ClassMemberModel;
use Classroom\Models\ClassRoomModel;
use Heroicadmin\Controllers\AdminController;

class Member extends AdminController
{
    protected $db;
    protected $classModel;
    protected $memberModel;

    public function __construct()
    {
        $this->data['module']    = 'classroom';
        $this->data['submodule'] = 'classes';

        $this->db         = \Config\Database::connect();
        $this->classModel = new ClassRoomModel();
        $this->memberModel = new ClassMemberModel();
    }

    private function loadClass(int $classId): ?array
    {
        $class = $this->classModel->find($classId);
        if ($class) {
            $this->data['class']      = $class;
            $this->data['page_title'] = 'Peserta — ' . $class['name'];
        }

        return $class;
    }

    private function notFound(string $message = 'Kelas tidak ditemukan')
    {
        session()->setFlashdata('error_message', $message);

        return redirect()->to(urlScope() . '/classroom/classes');
    }

    public function index($classId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $this->data['members'] = $this->memberModel->forClassWithUsers($class['id']);

        return view('Classroom\Views\member\index', $this->data);
    }

    public function data($classId)
    {
        $class = $this->loadClass((int) $classId);
        if (! $class) {
            return $this->response->setJSON(['data' => []]);
        }

        return $this->response->setJSON([
            'data' => $this->memberModel->forClassWithUsers($class['id']),
        ]);
    }

    public function search($classId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->response->setJSON([]);
        }

        $q = $this->request->getGet('q') ?: '';

        return $this->response->setJSON(
            $this->memberModel->searchUsers($class['id'], $q)
        );
    }

    public function add($classId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $userId = (int) $this->request->getPost('user_id');
        $role   = $this->request->getPost('role') === 'instructor' ? 'instructor' : 'member';

        if (! $userId) {
            session()->setFlashdata('error_message', 'Pilih user terlebih dahulu');

            return redirect()->back();
        }

        $result = $this->memberModel->addOrReactivate($class['id'], $userId, $role);
        session()->setFlashdata('success_message', $result === 'reactivated'
            ? 'Member yang sebelumnya dropped berhasil diaktifkan kembali'
            : 'Member berhasil ditambahkan');

        return redirect()->back();
    }

    public function bulk($classId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $emails = $this->request->getPost('emails');
        $role   = $this->request->getPost('role') === 'instructor' ? 'instructor' : 'member';

        // Dukung input: textarea satu-per-baris, atau upload CSV, atau array
        $identifiers = [];
        if (is_array($emails)) {
            $identifiers = array_map('trim', $emails);
        } elseif ($emails) {
            $identifiers = array_filter(array_map('trim', preg_split('/[\r\n,]+/', $emails)));
        }

        $file = $this->request->getFile('csv_file');
        if ($file && $file->isValid() && $file->getClientMimeType() === 'text/csv') {
            $handle = fopen($file->getTempName(), 'r');
            if ($handle) {
                while (($row = fgetcsv($handle)) !== false) {
                    $value = trim($row[0] ?? '');
                    if ($value !== '') {
                        $identifiers[] = $value;
                    }
                }
                fclose($handle);
            }
        }

        $identifiers = array_values(array_unique(array_filter($identifiers)));

        if (empty($identifiers)) {
            session()->setFlashdata('error_message', 'Tidak ada data untuk ditambahkan');

            return redirect()->back();
        }

        $report = ['added' => 0, 'skipped' => 0, 'not_found' => 0, 'skipped_list' => [], 'not_found_list' => []];

        foreach ($identifiers as $identifier) {
            $user = $this->memberModel->findUserByIdentifier($identifier);
            if (! $user) {
                $report['not_found']++;
                $report['not_found_list'][] = $identifier;
                continue;
            }

            $existing = $this->db->table('cls_class_members')
                ->where('class_id', $class['id'])
                ->where('user_id', $user['id'])
                ->get()->getRowArray();

            if ($existing && $existing['status'] === 'active') {
                $report['skipped']++;
                $report['skipped_list'][] = $identifier;
                continue;
            }

            $this->memberModel->addOrReactivate($class['id'], $user['id'], $role);
            $report['added']++;
        }

        session()->setFlashdata('success_message',
            "Import selesai: {$report['added']} ditambahkan, {$report['skipped']} dilewati (sudah aktif), {$report['not_found']} tidak ditemukan."
        );

        if ($report['not_found'] > 0) {
            session()->setFlashdata('warning_message', 'Tidak ditemukan: ' . implode(', ', array_slice($report['not_found_list'], 0, 10)));
        }

        return redirect()->back();
    }

    public function drop($classId, $memberId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $this->db->table('cls_class_members')
            ->where('id', $memberId)
            ->where('class_id', $class['id'])
            ->update(['status' => 'dropped']);

        session()->setFlashdata('success_message', 'Member berhasil di-drop');

        return redirect()->back();
    }

    public function restore($classId, $memberId)
    {
        $class = $this->classModel->find((int) $classId);
        if (! $class) {
            return $this->notFound();
        }

        $this->db->table('cls_class_members')
            ->where('id', $memberId)
            ->where('class_id', $class['id'])
            ->update(['status' => 'active']);

        session()->setFlashdata('success_message', 'Member berhasil diaktifkan kembali');

        return redirect()->back();
    }
}
