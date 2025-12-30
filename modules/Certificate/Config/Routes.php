<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') .'/certificates', 
    ['namespace' => 'Certificate\Controllers'], 
    function ($routes) {
    $routes->get('/', 'CertificateController::index');
    $routes->get('create', 'CertificateController::create');
    $routes->post('store', 'CertificateController::store');
    $routes->get('edit/(:num)', 'CertificateController::edit/$1');
    $routes->post('update/(:num)', 'CertificateController::update/$1');
    $routes->post('delete/(:num)', 'CertificateController::delete/$1');
    $routes->get('view/(:num)', 'CertificateController::view/$1');
    $routes->post('toggle-status/(:num)', 'CertificateController::toggleStatus/$1');
});
