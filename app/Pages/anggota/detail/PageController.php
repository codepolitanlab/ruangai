<?php namespace App\Pages\anggota\detail;

use App\Pages\MobileBaseController;

class PageController extends MobileBaseController {
    
    public function getContent()
    {
        return pageView('anggota/detail/index', $this->data);
    }
    
    public function getSupply($user_id)
    {
		$member = $this->member($user_id);
		$tagihan = $this->tagihan($user_id);

        return $this->respond(['found' => 1, 'member' => $member, 'tagihan' => $tagihan]);
    }

    private function member($user_id)
	{
        $db = \Config\Database::connect();
		$user = $db->table('users')
					 ->select('users.id, name, avatar, username, anggota.kd_pc, nama_pc, avatar, short_description')
					 ->join('anggota', 'anggota.npa = users.username')
					 ->join('masagi_pc', 'anggota.kd_pc = masagi_pc.kd_pc')
					 ->where('users.id', $user_id)
					 ->get()
                     ->getRowArray();

		return $user;
	}

	private function tagihan($user_id)
	{
        $db = \Config\Database::connect();
		$tagihan = $db->table('md_bills')
					 ->select('id, title, amount, status')
					 ->where('user_id', $user_id)
					 ->orderBy('start_date', 'asc')
					 ->get()
                     ->getResultArray();

		$data = [];
		if($tagihan)
		{
			foreach($tagihan as $key => $value)
			{
				if($value['status'] == 'paid')
					$data['paid'][$value['id']] = $value;
				else
					$data['unpaid'][$value['id']] = $value;
			}
		}

		return $data;
	}

}