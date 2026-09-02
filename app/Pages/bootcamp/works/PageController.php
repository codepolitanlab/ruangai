<?php

namespace App\Pages\bootcamp\works;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Karya Saya',
        'module'     => 'bootcamp',
        'active_page' => 'bootcamp',
        'body_class' => 'rd-dashboard-page',
    ];

    /**
     * GET /bootcamp/works/data — daftar karya milik user (filter status opsional).
     */
    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        $status = $this->request->getGet('status');
        $status = is_string($status) ? $status : '';

        $builder = $db->table('cls_member_works')
            ->where('user_id', $userId)
            ->where('deleted_at IS NULL');

        if ($status !== '' && in_array($status, ['pending', 'published', 'rejected'], true)) {
            $builder->where('status', $status);
        }

        $works = $builder->orderBy('created_at', 'DESC')->get()->getResultArray();

        foreach ($works as &$work) {
            $work['photos_arr'] = $this->decodePhotos($work['photos']);
        }
        unset($work);

        $counts = ['pending' => 0, 'published' => 0, 'rejected' => 0];
        foreach ($works as $work) {
            if (isset($counts[$work['status']])) {
                $counts[$work['status']]++;
            }
        }

        $this->data['works']  = $works;
        $this->data['counts'] = $counts;
        $this->data['filter'] = $status;
        $this->data['user']   = [
            'name'  => $jwt->user['name'] ?? '',
            'email' => $jwt->user['email'] ?? '',
        ];

        return $this->respondSecure($this->data);
    }

    /**
     * POST /bootcamp/works/store — buat karya baru (status pending).
     */
    public function postStore()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        $title = trim((string) $this->request->getPost('title'));
        $short = trim((string) $this->request->getPost('short_description'));
        $desc  = trim((string) $this->request->getPost('description'));
        $thumb = trim((string) $this->request->getPost('thumbnail'));
        $urlProject = trim((string) $this->request->getPost('url_project'));

        if ($title === '') {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Judul karya wajib diisi.']);
        }

        if (mb_strlen($short) > 500) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Deskripsi singkat maksimal 500 karakter.']);
        }

        $photos = $this->request->getPost('photos');
        $photosArr = [];

        if (is_array($photos)) {
            foreach ($photos as $p) {
                $p = trim((string) $p);
                if ($p !== '' && filter_var($p, FILTER_VALIDATE_URL)) {
                    $photosArr[] = $p;
                }
            }
        }

        $db->table('cls_member_works')->insert([
            'user_id'           => $userId,
            'title'             => esc($title),
            'thumbnail'         => $thumb !== '' && filter_var($thumb, FILTER_VALIDATE_URL) ? esc($thumb) : null,
            'photos'            => $photosArr ? json_encode($photosArr) : null,
            'description'       => esc($desc),
            'short_description' => esc($short),
            'status'            => 'pending',
            'url_project'       => $urlProject !== '' ? esc($urlProject) : null,
        ]);

        return $this->respondSecure([
            'status'  => 'success',
            'message' => 'Karya berhasil dikirim dan menunggu moderasi.',
        ]);
    }

    /**
     * POST /bootcamp/works/update/{id} — edit karya sendiri (hanya status pending).
     */
    public function postUpdate($id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        $work = $db->table('cls_member_works')
            ->where('id', (int) $id)
            ->where('user_id', $userId)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $work) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Karya tidak ditemukan.']);
        }

        if ($work['status'] !== 'pending') {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Karya hanya bisa diedit saat status pending.']);
        }

        $title = trim((string) $this->request->getPost('title'));
        $short = trim((string) $this->request->getPost('short_description'));
        $desc  = trim((string) $this->request->getPost('description'));
        $thumb = trim((string) $this->request->getPost('thumbnail'));
        $urlProject = trim((string) $this->request->getPost('url_project'));

        if ($title === '') {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Judul karya wajib diisi.']);
        }

        if (mb_strlen($short) > 500) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Deskripsi singkat maksimal 500 karakter.']);
        }

        $photos = $this->request->getPost('photos');
        $photosArr = [];

        if (is_array($photos)) {
            foreach ($photos as $p) {
                $p = trim((string) $p);
                if ($p !== '' && filter_var($p, FILTER_VALIDATE_URL)) {
                    $photosArr[] = $p;
                }
            }
        }

        $db->table('cls_member_works')->where('id', (int) $id)->update([
            'title'             => esc($title),
            'thumbnail'         => $thumb !== '' && filter_var($thumb, FILTER_VALIDATE_URL) ? esc($thumb) : null,
            'photos'            => $photosArr ? json_encode($photosArr) : null,
            'description'       => esc($desc),
            'short_description' => esc($short),
            'url_project'       => $urlProject !== '' ? esc($urlProject) : null,
        ]);

        return $this->respondSecure([
            'status'  => 'success',
            'message' => 'Karya berhasil diperbarui.',
        ]);
    }

    /**
     * POST /bootcamp/works/delete/{id} — hapus karya sendiri (soft delete).
     */
    public function postDelete($id)
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();
        $userId = (int) $jwt->user_id;

        $work = $db->table('cls_member_works')
            ->where('id', (int) $id)
            ->where('user_id', $userId)
            ->where('deleted_at IS NULL')
            ->get()
            ->getRowArray();

        if (! $work) {
            return $this->respondSecure(['status' => 'failed', 'message' => 'Karya tidak ditemukan.']);
        }

        $db->table('cls_member_works')
            ->where('id', (int) $id)
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);

        return $this->respondSecure([
            'status'  => 'success',
            'message' => 'Karya berhasil dihapus.',
        ]);
    }

    private function decodePhotos(?string $photos): array
    {
        if (! $photos) {
            return [];
        }

        $decoded = json_decode($photos, true);

        return is_array($decoded) ? $decoded : [];
    }
}
