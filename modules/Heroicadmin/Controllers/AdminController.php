<?php

namespace Heroicadmin\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AdminController extends BaseController
{
    public $data = [
        'page_title' => 'Homepage',
        'module'     => 'dashboard',
        'submodule'  => 'dashboard',
    ];

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        // Load helper
        helper('Heroicadmin\Helpers\heroicadmin');
        helper('Heroicadmin\Helpers\heroicsetting');

        // Check session
        if (! user_id()) {
            header('Location: /' . urlScope() . '/user/login');
        }
    }
}
