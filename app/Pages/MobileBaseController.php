<?php namespace App\Pages;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class MobileBaseController extends BaseController 
{
	public $data = [];

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

		$this->data['title'] = 'HeroicAdmin';
		$this->data['page_title'] = 'Beranda';
		$this->data['themeURL'] = base_url('mobilekit') .'/'; 
        $this->data['themePath'] = 'mobilekit/'; 
        $this->data['version'] = "1.0.0";
    }

	// This method handle GET request
	public function getIndex()
	{
		return pageView('mobileLayout', $this->data);
	}

}