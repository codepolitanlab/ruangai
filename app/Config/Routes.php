<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('cobacoba', 'Home::index');

// Api
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    $routes->get('scholarship', 'ScholarshipController::index');
    $routes->post('scholarship', 'ScholarshipController::create');
});


service('auth')->routes($routes);
