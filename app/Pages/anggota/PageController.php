<?php namespace App\Pages\anggota;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController {
    
    public function getContent()
    {
        return pageView('anggota/index', $this->data);
    }
    
    public function getSupply()
    {
        $db = \Config\Database::connect();
        $users = $db->table('users')
                    ->select('users.id, name, avatar, username, anggota.kd_pc, nama_pc')
                    ->join('anggota', 'anggota.npa = users.username')
                    ->join('masagi_pc', 'anggota.kd_pc = masagi_pc.kd_pc')
                    ->get()
                    ->getResultArray();

        return $this->respond(['found' => 1, 'members' => $users]);
    }

}