<?php namespace App\Pages\zpanel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AdminController extends BaseController
{
	
	public $data = [
		'page_title' => 'Homepage'
	];

	public function initController(
		RequestInterface $request, 
		ResponseInterface $response, 
		LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

		// Check session
		if (!session()->get('logged_in')) {
			header('Location: zpanel/login');
		}
    }

}
