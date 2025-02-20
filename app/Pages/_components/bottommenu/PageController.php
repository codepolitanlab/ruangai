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
				"label" => "Kabar",
				"url" => "/feeds",
				"icon" => '<i class="bi bi-newspaper"></i>'
			],
			[
				"label" => "Anggota",
				"url" => "/anggota",
				"icon" => '<i class="bi bi-person-vcard"></i>'
			],
			[
				"label" => "Iuran",
				"url" => "/iuran",
				"icon" => '<i class="bi bi-cash-coin"></i>'
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
