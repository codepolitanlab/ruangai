<?php

namespace Heroicadmin\Modules\User\Controllers;

use Heroicadmin\Controllers\AdminController;

class Token extends AdminController
{
    public $data = [
        'page_title' => 'User Token',
        'module'     => 'user',
        'submodule'  => 'token',
    ];

    public function index()
    {
        $userRewardTokens = model('UserToken');
        $this->data['userRewardTokens'] = $userRewardTokens->select('user_reward_tokens.*, users.name')
            ->join('users', 'users.id = user_reward_tokens.user_id')
            ->asObject()
            ->orderBy('created_at', 'DESC')
            ->paginate(50);
        $this->data['pager'] = $userRewardTokens->pager;
        $this->data['total_token'] = $userRewardTokens->countAllResults();

        return pageView('Heroicadmin\Modules\User\Views\token\index', $this->data);
    }

    public function import()
    {
        return pageView('Heroicadmin\Modules\User\Views\token\import', $this->data);
    }

    public function generate()
    {
        $file = $this->request->getFile('userfile');

        if (! $file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        $reward_from = $this->request->getPost('reward_from');

        $userTokenModel = model('UserToken');
        $userModel      = model('UserModel');

        $handle = fopen($file->getTempName(), 'rb');
        fgetcsv($handle); // skip header

        $imported = 0;
        $skipped  = 0;
        $notFound = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $email = strtolower(trim($row[0]));

            if (empty($email)) {
                continue;
            }

            // Cari user berdasarkan email
            $user = $userModel->where('email', $email)->first();

            if (! $user) {
                $notFound++;
                continue;
            }

            // Cek apakah sudah ada data reward token untuk user ini
            $exists = $userTokenModel->isExists($user['id'], $reward_from);

            if ($exists) {
                $skipped++;
                continue;
            }

            // Insert reward token
            $userTokenModel->generate($user['id'], $reward_from);

            $imported++;
        }
        fclose($handle);

        $message = "Import selesai. {$imported} data berhasil disimpan.";
        if ($skipped > 0) {
            $message .= " {$skipped} data dilewati karena sudah ada.";
        }
        if ($notFound > 0) {
            $message .= " {$notFound} email tidak ditemukan di tabel user.";
        }

        return redirect()->back()->with('success', $message);
    }
}
