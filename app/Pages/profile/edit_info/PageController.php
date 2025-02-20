<?php namespace App\Pages\profile\edit_info;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController {

    public function getContent()
    {
        return pageView('profile/edit_info/index', $this->data);
    }

    public function getSupply()
    {
        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();

        $logoSetting = $db->table('mein_options')
                          ->where('option_name', 'auth_logo')
                          ->where('option_group', 'app')
                          ->get()->getRowArray();
        $data['logo'] = $logoSetting['option_value'] ?? null; 

        return $data;
    }

    public function postIndex()
    {
        $validation = service('validation');

        $validation->setRules([
            "name" => 'required|min_length[2]',
            "short_description" => 'max_length[255]',
            "jobs" => 'max_length[255]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            $errors = $validation->getErrors();
            return $this->respond([
                'success' => 0, 'errors' => $errors
            ]);
        }
        $validData = $validation->getValidated();

        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();
        $user = $Heroic->checkToken();

        // Update name
        $userData = [
            "name" => $validData['name'],
            "short_description" => $validData['short_description'],
        ];
        $db->table('users')->where('id', $user->user_id)->update($userData);

        // Update or insert profile if not exists
        $profileData = [
            "user_id" => $user->user_id,
            "gender" => $this->request->getPost('gender'),
            "birthday" => date("Y-m-d", strtotime($this->request->getPost('birthday'))),
            "status_marital" => $this->request->getPost('status_marital'),
            "jobs" => $this->request->getPost('jobs'),
        ];
        $db->table('mein_user_profile')->where('user_id', $user->user_id)->update($profileData);
        if($db->affectedRows() == 0) {
            $db->table('mein_user_profile')->insert($profileData);
        }
        if($db->affectedRows() > 0) {
            return $this->respond([
                'success' => 1, 'message' => 'Data profil berhasil diperbaharui.'
            ]);
        } else {
            return $this->respond([
                'success' => 0, 'message' => 'Gagal memperbaharui profil.'
            ]);
        }
        die;
    }
}