<?php

namespace App\Pages\profile\edit_info;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Edit Info Profil',
        'module'     => 'profile',
        'body_class' => 'rd-dashboard-page',
    ];

    public function getSupply()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();

        $user = $db->table('users')
            ->select('id, name, email, phone, gender, birth_date')
            ->where('id', $jwt->user_id)
            ->get()
            ->getRowArray();

        $profile = $db->table('user_profiles')
            ->where('user_id', $jwt->user_id)
            ->where('deleted_at', null)
            ->get()
            ->getRowArray();

        $data['profile'] = [
            'name'       => $user['name'] ?? null,
            'email'      => $user['email'] ?? null,
            'gender'     => $profile['gender'] ?? ($user['gender'] ?? null),
            'birthday'   => $profile['birthday'] ?? null,
            'occupation' => $profile['occupation'] ?? null,
            'bio'        => $profile['bio'] ?? null,
        ];

        return $this->respond($data);
    }

    public function postIndex()
    {
        $validation = service('validation');

        $validation->setRules([
            'name'       => 'required|min_length[2]|max_length[255]',
            'gender'     => 'permit_empty|in_list[male,female]',
            'birthday'   => 'permit_empty',
            'occupation' => 'permit_empty|max_length[255]',
            'bio'        => 'permit_empty|max_length[500]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            return $this->respond([
                'success' => 0,
                'errors'  => $validation->getErrors(),
            ]);
        }
        $validData = $validation->getValidated();

        $Heroic = new \App\Libraries\Heroic();
        $jwt    = $Heroic->checkToken(true);
        $db     = \Config\Database::connect();

        $birthdayRaw = trim((string) ($validData['birthday'] ?? ''));
        $birthday    = ($birthdayRaw !== '' && strtotime($birthdayRaw) !== false)
            ? date('Y-m-d', strtotime($birthdayRaw))
            : null;

        // Simpan ke tabel users
        $db->table('users')
            ->where('id', $jwt->user_id)
            ->update([
                'name'       => $validData['name'],
                'gender'     => $validData['gender'] ?? null,
                'birth_date' => $birthday,
            ]);

        // Upsert ke tabel user_profiles
        $profileModel    = new \App\Models\UserProfile();
        $existingProfile = $profileModel
            ->where('user_id', $jwt->user_id)
            ->where('deleted_at', null)
            ->first();

        $profilePayload = [
            'user_id'    => $jwt->user_id,
            'gender'     => $validData['gender'] ?? null,
            'birthday'   => $birthday,
            'occupation' => $validData['occupation'] ?? null,
            'bio'        => trim((string) ($validData['bio'] ?? '')) ?: null,
        ];

        if ($existingProfile) {
            $saved = $profileModel->update($existingProfile['id'], $profilePayload);
        } else {
            $saved = $profileModel->insert($profilePayload);
        }

        if ($saved) {
            return $this->respond([
                'success' => 1,
                'message' => 'Data profil berhasil diperbarui.',
            ]);
        }

        return $this->respond([
            'success' => 0,
            'message' => 'Gagal memperbarui profil.',
        ]);
    }
}
