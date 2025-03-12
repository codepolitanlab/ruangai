<?php

namespace App\Controllers;

class Assetlink extends BaseController
{
    public function index(): string
    {
        $domain = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
        // Check in writable/dal folder
        if(file_exists('../writable/dal/'.$domain)) {
            $this->response->setContentType('application/json');
            return file_get_contents('../writable/dal/'.$domain);
        }
    }
}
