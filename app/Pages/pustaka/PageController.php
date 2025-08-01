<?php

namespace App\Pages\pustaka;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Daftar Artikel',
    ];

    public function getData($page = 1)
    {
        // Retrieve extension attributes
        $perpage = (int) ($this->request->getGet('perpage') ?? 15);
        $offset  = ($page - 1) * $perpage;

        $db    = \Config\Database::connect();
        $query = 'SELECT * FROM mein_microblogs LIMIT :limit: OFFSET :offset:';

        $microblogs = $db->query($query, [
            'limit'  => $perpage,
            'offset' => $offset,
        ])->getResultArray();

        return $this->respond([
            'response_code'    => 200,
            'response_message' => 'success',
            'paginatedData'    => $microblogs,
        ]);
    }
}
