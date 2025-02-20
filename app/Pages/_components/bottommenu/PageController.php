<?php namespace App\Pages\_components\bottommenu;

use App\Controllers\BaseController;
use Symfony\Component\Yaml\Yaml;

class PageController extends BaseController {

    // Load member layout
    public function getIndex()
	{
		// Get bottom menu
		// Get database pesantren
        $Tarbiyya = new \App\Libraries\Tarbiyya();
        $db = \Config\Database::connect();
		if($db) {
			$bottommenu = $db->table('menus')
							->where('slug', 'bottommenu')
							->where('status', 1)
							->get()
							->getRowArray();
			$this->data['bottommenu'] = Yaml::parse($bottommenu['schema']);
        }
        
		return pageView('_components/bottommenu/index', $this->data);
	}

}