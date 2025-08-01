<?php

namespace App\Pages\page;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public function getSupply($slug = null)
    {
        // Retrieve extension attributes
        $uri = $this->request->getUri();

        // Get post data
        $query = "SELECT * FROM `mein_posts` WHERE `type` = 'page' AND `slug` = :slug: AND `status` = 'publish'";

        // Get database pesantren
        $db           = \Config\Database::connect();
        $data['page'] = $db->query($query, ['slug' => $slug])->getRowArray();

        return $this->respond($data);
    }
}
