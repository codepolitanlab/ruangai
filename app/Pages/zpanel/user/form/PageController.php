<?php

namespace App\Pages\zpanel\user\form;

use App\Controllers\BaseController;
use Exception;

class PageController extends BaseController
{
    public function getIndex()
    {
        $data['page_title'] = 'User Form';

        // Ambil ID dari URL jika ada
        $id = $this->request->getGet('id');
        if ($id) {
            // Mode Edit: Ambil data user beserta profilenya
            $userModel    = new \App\Models\UserModel();
            $data['user'] = $userModel->select('users.*, user_profiles.bank_name, user_profiles.account_name, user_profiles.account_number')
                ->join('user_profiles', 'user_profiles.user_id = users.id', 'left')
                ->where('users.id', $id)
                ->where('users.deleted_at', null)
                ->asObject()
                ->first();

            if (! $data['user']) {
                session()->setFlashdata('error', 'User tidak ditemukan');

                return redirect()->to('/zpanel/user');
            }

            $data['page_title'] = 'Edit User';
        }

        // Ambil data roles untuk dropdown
        $db            = \Config\Database::connect();
        $data['roles'] = $db->table('roles')
            ->get()
            ->getResult();

        return pageView('zpanel/user/form/index', $data);
    }

    public function postIndex()
    {
        $id = $this->request->getPost('id');

        $data = [
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'phone'   => $this->request->getPost('phone'),
            'avatar'  => $this->request->getPost('avatar'),
            'role_id' => $this->request->getPost('role_id'),
        ];
        $password         = $this->request->getPost('password');
        $password_confirm = $this->request->getPost('confirm_password');

        // Jika password diisi, tambahkan ke data
        if ($password) {
            if ($password !== $password_confirm) {
                session()->setFlashdata('error', 'Password tidak sama');

                return $id ? redirect()->to('/zpanel/user/form?id=' . $id) : redirect()->to('/zpanel/user/form');
            }
            $Phpass      = new \App\Libraries\Phpass();
            $data['pwd'] = $Phpass->HashPassword($password);
        }

        $userModel        = new \App\Models\UserModel();
        $userProfileModel = new \App\Models\UserProfile();
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

            return redirect()->to('/zpanel/user');
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();

            exit();
        }
    }

    public function postDelete()
    {
        $id        = $this->request->getPost('id');
        $userModel = new \App\Models\UserModel();
        $userModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        session()->setFlashdata('success', 'Data berhasil dihapus');

        return redirect()->to('/zpanel/user');
    }
}
