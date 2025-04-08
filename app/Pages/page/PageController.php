<?php namespace App\Pages\page;

use App\Pages\BaseController;

class PageController extends BaseController {

    public function getContent()
    {
        return pageView('page/index', $this->data);
    }

    public function getSupply($slug = null)
    {
        // Retrieve extension attributes
        $uri = $this->request->getUri();

        // Get post data
		$query = "SELECT * FROM `mein_posts` WHERE `type` = 'page' AND `slug` = :slug: AND `status` = 'publish'";

        // Get database pesantren
        $Heroic = new \App\Libraries\Heroic();
        $db = \Config\Database::connect();
        $data['page'] = $db->query($query, ['slug' => $slug])->getRowArray();

		return $this->respond([
			'response_code'    => 200,
			'response_message' => 'success',
			'data'			   => $data 
		]);
    }

}