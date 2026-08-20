<?php

namespace Classroom\Controllers;

use App\Libraries\EmailSender;
use Classroom\Models\MemberWorkModel;
use Heroicadmin\Controllers\AdminController;

class MemberWork extends AdminController
{
    protected $db;
    protected $model;

    public function __construct()
    {
        $this->data['page_title'] = 'Karya Member';
        $this->data['module']     = 'classroom';
        $this->data['submodule']  = 'memberworks';

        $this->db    = \Config\Database::connect();
        $this->model = new MemberWorkModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?: '';
        $status = $this->request->getGet('status') ?: '';

        $this->data['search'] = $search;
        $this->data['status'] = $status;
        $this->data['works']  = $this->model->withUser([], $search, $status);

        return view('Classroom\Views\memberwork\index', $this->data);
    }

    public function data()
    {
        $request = $this->request;
        $draw    = (int) $request->getPost('draw');
        $start   = (int) ($request->getPost('start') ?? 0);
        $length  = (int) ($request->getPost('length') ?? 10);
        $search  = $request->getPost('search')['value'] ?? '';
        $status  = $request->getPost('status') ?? '';

        $builder = $this->db->table('cls_member_works w')
            ->select('w.*, u.name AS user_name, u.email AS user_email')
            ->join('mein_users u', 'u.id = w.user_id', 'left')
            ->where('w.deleted_at IS NULL');

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

        $total = $builder->countAllResults(false);
        $rows  = $builder->orderBy('w.created_at', 'DESC')
            ->limit($length, $start)
            ->get()->getResultArray();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'id'                => $row['id'],
                'title'             => $row['title'],
                'user_name'         => $row['user_name'],
                'user_email'        => $row['user_email'],
                'short_description' => $row['short_description'],
                'status'            => $row['status'],
                'created_at'        => $row['created_at'] ? date('d M Y', strtotime($row['created_at'])) : '-',
            ];
        }

        return $this->response->setJSON([
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $data,
        ]);
    }

    public function show($id)
    {
        $work = $this->model->findWithUser((int) $id);
        if (! $work) {
            session()->setFlashdata('error_message', 'Karya tidak ditemukan');

            return redirect()->to(urlScope() . '/classroom/memberworks');
        }

        $this->data['work']  = $work;
        $this->data['photos'] = MemberWorkModel::decodePhotos($work['photos']);
        $this->data['page_title'] = 'Detail Karya — ' . $work['title'];

        return view('Classroom\Views\memberwork\show', $this->data);
    }

    public function create()
    {
        $this->data['work']   = null;
        $this->data['photos'] = [];
        $this->data['page_title'] = 'Buat Karya';

        return view('Classroom\Views\memberwork\form', $this->data);
    }

    public function edit($id)
    {
        $work = $this->model->find((int) $id);
        if (! $work) {
            session()->setFlashdata('error_message', 'Karya tidak ditemukan');

            return redirect()->to(urlScope() . '/classroom/memberworks');
        }

        $this->data['work']   = $work;
        $this->data['photos'] = MemberWorkModel::decodePhotos($work['photos']);
        $this->data['page_title'] = 'Edit Karya — ' . $work['title'];

        return view('Classroom\Views\memberwork\form', $this->data);
    }

    public function store()
    {
        $data = [
            'user_id'           => (int) $this->request->getPost('user_id') ?: user_id(),
            'title'             => $this->request->getPost('title'),
            'short_description' => $this->request->getPost('short_description'),
            'description'       => $this->request->getPost('description'),
            'thumbnail'         => $this->request->getPost('thumbnail'),
            'url_project'       => $this->request->getPost('url_project'),
            'status'            => $this->request->getPost('status') ?: 'pending',
        ];

        $photos = $this->collectPhotos();
        if (! empty($photos)) {
            $data['photos'] = json_encode($photos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        if (! $this->model->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->model->errors()));

            return redirect()->back()->withInput();
        }

        $this->model->insert($data);
        session()->setFlashdata('success_message', 'Karya berhasil dibuat');

        return redirect()->to(urlScope() . '/classroom/memberworks');
    }

    public function update($id)
    {
        $work = $this->model->find((int) $id);
        if (! $work) {
            session()->setFlashdata('error_message', 'Karya tidak ditemukan');

            return redirect()->back();
        }

        $data = [
            'user_id'           => (int) $this->request->getPost('user_id') ?: $work['user_id'],
            'title'             => $this->request->getPost('title'),
            'short_description' => $this->request->getPost('short_description'),
            'description'       => $this->request->getPost('description'),
            'thumbnail'         => $this->request->getPost('thumbnail'),
            'url_project'       => $this->request->getPost('url_project'),
            'status'            => $this->request->getPost('status') ?: $work['status'],
        ];

        $photos = $this->collectPhotos();
        if (! empty($photos)) {
            $data['photos'] = json_encode($photos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        if (! $this->model->validate($data)) {
            session()->setFlashdata('error_message', implode('<br>', $this->model->errors()));

            return redirect()->back()->withInput();
        }

        $this->model->update($id, $data);
        session()->setFlashdata('success_message', 'Karya berhasil diperbarui');

        return redirect()->to(urlScope() . '/classroom/memberworks');
    }

    public function moderate($id)
    {
        $work = $this->model->find((int) $id);
        if (! $work) {
            session()->setFlashdata('error_message', 'Karya tidak ditemukan');

            return redirect()->back();
        }

        $status = $this->request->getPost('status');
        if (! in_array($status, ['published', 'rejected'], true)) {
            session()->setFlashdata('error_message', 'Status moderasi tidak valid');

            return redirect()->back();
        }

        $this->model->update($id, ['status' => $status]);

        // Kirim email notifikasi saat karya disetujui (published)
        if ($status === 'published') {
            $this->sendApprovalEmail($work);
        }

        session()->setFlashdata('success_message', $status === 'published'
            ? 'Karya disetujui dan dipublikasikan'
            : 'Karya ditolak');

        return redirect()->back();
    }

    public function delete($id)
    {
        $this->model->delete((int) $id);
        session()->setFlashdata('success_message', 'Karya berhasil dihapus');

        return redirect()->to(urlScope() . '/classroom/memberworks');
    }

    /**
     * Kumpulkan daftar URL galeri dari input dinamis photos[].
     */
    private function collectPhotos(): array
    {
        $photos = $this->request->getPost('photos');
        if (! is_array($photos)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', $photos)));
    }

    private function sendApprovalEmail(array $work): void
    {
        try {
            $user = $this->db->table('mein_users')
                ->where('id', $work['user_id'])
                ->get()->getRowArray();

            if (! $user || empty($user['email'])) {
                return;
            }

            $sender = new EmailSender();
            $sender->setTemplate('member_work_approved', [
                'name'  => $user['name'] ?? '',
                'title' => $work['title'],
                'url'   => base_url('bootcamp/works'),
            ]);

            $sender->send(
                $user['email'],
                'Karyamu Telah Disetujui — ' . $work['title']
            );
        } catch (\Throwable $e) {
            log_message('error', '[Classroom] Gagal kirim email karya disetujui: ' . $e->getMessage());
        }
    }
}
