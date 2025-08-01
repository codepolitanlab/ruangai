<?php

namespace App\Pages\zpanel\user;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'Users';

        // Definisikan field yang bisa difilter
        $filterFields = ['id' => 'users.id', 'name' => 'name', 'email' => 'email', 'role' => 'role_id'];
        $filters      = [];

        // Ambil semua filter dari URL secara dinamis
        foreach ($filterFields as $param => $field) {
            $filterValue = $this->request->getGet('filter_' . $param);
            if ($filterValue) {
                $filters[$field] = $filterValue;
            }
            // Simpan nilai filter untuk ditampilkan kembali di form
            $data['filter_' . $param] = $filterValue;
        }

        // Ambil model Users
        $userModel = new \App\Models\UserModel();

        // Set jumlah item per halaman
        $per_page = 10;

        // Ambil current page dari URL, default 1
        $current_page = $this->request->getGet('page') ?? 1;

        // Buat query dasar
        $baseQuery = $userModel->where('deleted_at', null);

        // Terapkan semua filter yang aktif
        foreach ($filters as $field => $value) {
            $baseQuery->like($field, $value);
        }

        // Clone query untuk total_users agar tidak terpengaruh pagination
        $totalQuery = clone $baseQuery;

        // Ambil data paginasi dengan output array object
        $data['users'] = $baseQuery
            ->select('users.*, roles.role_name')
            ->orderBy('created_at', 'DESC')
            ->join('roles', 'roles.id = users.role_id')
            ->asObject()
            ->paginate($per_page);

        // Simpan pager untuk ditampilkan di view
        $data['pager'] = $userModel->pager;

        // Hitung total users berdasarkan filter yang aktif
        if (! empty($filters)) {
            $data['total_users'] = count($data['users']);
        } else {
            $data['total_users'] = $totalQuery->countAllResults();
        }

        // Tambahkan current_page dan per_page ke data
        $data['current_page'] = $current_page;
        $data['per_page']     = $per_page;

        // Get roles for dropdown
        $db            = \Config\Database::connect();
        $data['roles'] = $db->table('roles')
            ->select('id, role_name')
            ->where('status', 'active')
            ->get()
            ->getResultArray();

        return pageView('zpanel/user/index', $data);
    }
}
