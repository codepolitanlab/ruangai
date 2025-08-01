<?php

namespace App\Pages\webpush;

use App\Pages\BaseController;

class PageController extends BaseController
{
    public $data = [
        'page_title' => 'Webpush Page',
    ];

    public function getData()
    {
        $this->data['name'] = 'Mustafa Tillman';

        return $this->respond([
            'data' => $this->data,
        ]);
    }
}
