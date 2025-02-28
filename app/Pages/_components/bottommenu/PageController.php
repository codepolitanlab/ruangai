<?php

namespace App\Pages\_components\bottommenu;

use App\Controllers\BaseController;
use Symfony\Component\Yaml\Yaml;

class PageController extends BaseController {

    // Load member layout
    public function getIndex()
	{
		$data['bottommenu'] = [
			[
				"label" => "Beranda",
				"url" => "/",
				"icon" => '<i class="bi bi-house"></i>'
			],
			[
				"label" => "Courses",
				"url" => "/courses",
				"icon" => '<i class="bi bi-book"></i>'
			],
			[
				"label" => "Kabar",
				"url" => "/feeds",
				"icon" => '<i class="bi bi-newspaper"></i>'
			],
			[
				"label" => "Akun",
				"url" => "/profile",
				"icon" => '<i class="bi bi-person-circle"></i>'
			],
		];
        
		return pageView('_components/bottommenu/index', $data);
	}	

}
