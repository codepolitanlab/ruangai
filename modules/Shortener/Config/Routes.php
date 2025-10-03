<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/shortener',
    ['namespace' => 'Shortener\Controllers'],
    static function ($routes) {

        $routes->get('/', 'Shortener::index');
        $routes->get('add', 'Shortener::add');
        $routes->post('add', 'Shortener::add');
        $routes->get('(:num)/edit', 'Shortener::edit/$1');
        $routes->post('(:num)/edit', 'Shortener::edit/$1');
        $routes->get('(:num)/delete', 'Shortener::delete/$1');
    }
);
