<?php namespace App\Pages\zpanel;

use App\Pages\BaseController as PagesBaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AdminController extends PagesBaseController
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

		// Preload any models, libraries, etc, here.

		$this->data['themeURL'] = base_url('admin') .'/'; 
        $this->data['themePath'] = 'admin/'; 
    }

}
