<?php

/**
 * Event Module Routes
 */

$routes->group('heroic/event', ['namespace' => 'Event\Controllers'], function ($routes) {
    // CRUD routes
    $routes->get('/', 'Event::index');
    $routes->get('add', 'Event::add');
    $routes->post('add', 'Event::add');
    $routes->get('edit/(:num)', 'Event::edit/$1');
    $routes->post('edit/(:num)', 'Event::edit/$1');
    $routes->get('delete/(:num)', 'Event::delete/$1');
    $routes->post('delete/(:num)', 'Event::delete/$1');
    
    // Participants management
    $routes->get('participants/(:num)', 'Event::participants/$1');
    $routes->post('participants/add/(:num)', 'Event::addParticipant/$1');
    $routes->post('participants/attendance/(:num)', 'Event::updateAttendance/$1');
    $routes->post('participants/certificate/(:num)', 'Event::issueCertificate/$1');
    
    // Sessions management
    $routes->get('sessions/(:num)', 'Event::sessions/$1');
});
