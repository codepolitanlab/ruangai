<?php namespace App\Pages\certificate;

use App\Pages\BaseController;

class PageController extends BaseController 
{
    public $data = [
        'page_title' => "Sertifikat RuangAI",
        'module'     => 'certificate',
    ];

    public function getData()
    {
        $Heroic = new \App\Libraries\Heroic();
        $jwt = $Heroic->checkToken(true);

        $db = \Config\Database::connect();
        $certificate = $db->table('certificates')
            ->where('user_id', $jwt->user_id)
            ->where('is_active', 1)
            ->orderBy('cert_claim_date', 'DESC')
            ->get()
            ->getResultArray();
        $this->data['certificates'] = $certificate;

        return $this->respond($this->data);
    }
}
