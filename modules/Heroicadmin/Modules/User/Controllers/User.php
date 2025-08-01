<?php

namespace Heroicadmin\Modules\User\Controllers;

use Exception;
use Heroicadmin\Controllers\AdminController;

class User extends AdminController
{
    public function __construct()
    {
        $this->data['page_title'] = 'Users';
        $this->data['module']     = 'user';
        $this->data['submodule']  = 'user';
    }

    public function index()
    {
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
        $userModel = new \Heroicadmin\Modules\User\Models\UserModel();

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
            ->join('roles', 'roles.id = role_id')
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

        $this->data = array_merge($this->data, $data);

        return view('Heroicadmin\Modules\User\Views\user\index', $this->data);
    }

    public function form()
    {
        $data['page_title'] = 'User Form';

        // Ambil ID dari URL jika ada
        $id = $this->request->getGet('id');
        if ($id) {
            // Mode Edit: Ambil data user beserta profilenya
            $userModel    = new \Heroicadmin\Modules\User\Models\UserModel();
            $data['user'] = $userModel->select('users.*, user_profiles.bank_name, user_profiles.account_name, user_profiles.account_number')
                ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
                ->where('users.id', $id)
                ->where('users.deleted_at', null)
                ->asObject()
                ->first();

            if (! $data['user']) {
                session()->setFlashdata('error_message', 'User tidak ditemukan');

                return redirect()->to(urlScope() . '/user');
            }

            $data['page_title'] = 'Edit User';
        }

        // Ambil data roles untuk dropdown
        $db            = \Config\Database::connect();
        $data['roles'] = $db->table('roles')
            ->get()
            ->getResult();

        $this->data = array_merge($this->data, $data);

        return view('Heroicadmin\Modules\User\Views\user\form', $this->data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'phone'   => $this->request->getPost('phone'),
            'avatar'  => $this->request->getPost('avatar'),
            'role_id' => $this->request->getPost('role_id'),
        ];
        $password         = $this->request->getPost('mypassword');
        $password_confirm = $this->request->getPost('confirm_password');

        // Jika password diisi, tambahkan ke data
        if ($password) {
            if ($password !== $password_confirm) {
                session()->setFlashdata('error_message', 'Password tidak sama');

                return $id ? redirect()->to(urlScope() . '/user/form?id=' . $id) : redirect()->to(urlScope() . '/user/form');
            }
            $Phpass      = new \Heroicadmin\Modules\User\Libraries\Phpass();
            $data['pwd'] = $Phpass->HashPassword($password);
        }

        $userModel        = new \Heroicadmin\Modules\User\Models\UserModel();
        $userProfileModel = new \Heroicadmin\Modules\User\Models\UserProfileModel();
        $db               = \Config\Database::connect();

        try {
            // Update atau insert user profile
            $profileData = [
                'bank_name'      => $this->request->getPost('bank_name'),
                'account_name'   => $this->request->getPost('account_name'),
                'account_number' => $this->request->getPost('account_number'),
            ];

            if ($id) {
                $userModel->update($id, $data);
                // Check table profiles if user_id exists, update, else insert new use
                $profile = $userProfileModel->where('user_id', $id)->first();
                if (! $profile) {
                    $profileData['user_id'] = $id;
                    $userProfileModel->insert($profileData);
                } else {
                    $userProfileModel->update($profile['id'], $profileData);
                }
            } else {
                $id                     = $userModel->insert($data);
                $profileData['user_id'] = $id;
                $userProfileModel->insert($profileData);
            }

            session()->setFlashdata('success', 'Data berhasil disimpan');

            return redirect()->to(urlScope() . '/user');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();

            exit();
        }
    }

    public function delete()
    {
        $id        = $this->request->getPost('id');
        $userModel = new \Heroicadmin\Modules\User\Models\UserModel();
        $userModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        session()->setFlashdata('success', 'Data berhasil dihapus');

        return redirect()->to(urlScope() . '/user');
    }
}
