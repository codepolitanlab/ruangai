<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('testing', 'Home::index');

// Api
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    // Route login
    $routes->post('auth/send-otp', 'AuthController::sendOtp');
    $routes->post('auth/verify-otp', 'AuthController::verifyOtp');
    $routes->post('auth/register', 'AuthController::register');

    // Route scholarship
    $routes->get('scholarship', 'ScholarshipController::index');
    $routes->post('scholarship', 'ScholarshipController::register');
});


service('auth')->routes($routes);
