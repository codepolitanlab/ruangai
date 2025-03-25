<?php namespace App\Pages;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Yllumi\Heroic\Controllers\PageBaseController;

class MobileBaseController extends PageBaseController 
{
	public $data = [];

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

		$this->data['title'] = 'HeroicAdmin';
		$this->data['themeURL'] = base_url('mobilekit') .'/'; 
        $this->data['themePath'] = 'mobilekit/'; 
        $this->data['version'] = "1.0.0";
    }

	// This method handle GET request
	public function getIndex()
	{
		return pageView('layout', $this->data);
	}

}