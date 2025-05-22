<?php

namespace App\Pages\zpanel\user;

use App\Controllers\BaseController;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = "Users";

        // Ambil model Users
        $usersModel = new \App\Models\UserModel();

        // Set jumlah item per halaman
        $per_page = 5;

        // Ambil current page dari URL, default 1
        $current_page = $this->request->getGet('page') ?? 1;

        // Ambil data paginasi dengan output array object
        $data['users'] = $usersModel
            ->select('users.*, roles.role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.deleted_at', null)
            ->orderBy('users.created_at', 'DESC')
            ->asObject()
            ->paginate($per_page); // jumlah item per halaman

        // Simpan pager untuk ditampilkan di view
        $data['pager'] = $usersModel->pager;

        // Hitung total users tanpa paginate
        $data['total_users'] = $usersModel
            ->where('deleted_at', null)
            ->countAllResults(false); // false: jangan reset builder

        // Tambahkan current_page dan per_page ke data
        $data['current_page'] = $current_page;
        $data['per_page'] = $per_page;

        return pageView('zpanel/user/index', $data);
    }
}
