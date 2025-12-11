<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/scholarship',
    ['namespace' => 'Scholarship\Controllers'],
    static function ($routes) {
        $routes->get('events', 'Events::index');
        $routes->get('events/add', 'Events::add');
        $routes->post('events/add', 'Events::add');
        $routes->get('events/(:num)/edit', 'Events::edit/$1');
        $routes->post('events/(:num)/edit', 'Events::edit/$1');
        $routes->get('events/(:num)/delete', 'Events::delete/$1');

        $routes->get('participants', 'Participants::index');
        $routes->get('participants/add', 'Participants::add');
        $routes->post('participants/add', 'Participants::add');
        $routes->get('participants/(:num)/edit', 'Participants::edit/$1');
        $routes->post('participants/(:num)/edit', 'Participants::edit/$1');
        $routes->get('participants/(:num)/delete', 'Participants::delete/$1');

        $routes->get('followup-comentors', 'FollowupComentors::index');
        $routes->get('followup-comentors/(:num)/detail', 'FollowupComentors::detail/$1');
        $routes->get('followup-comentors/(:num)/import', 'FollowupComentors::import/$1');
        $routes->post('followup-comentors/(:num)/process-import', 'FollowupComentors::processImport/$1');
    }
);
