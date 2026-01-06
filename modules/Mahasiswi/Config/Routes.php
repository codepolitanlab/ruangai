<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/mahasiswi',
    ['namespace' => 'Mahasiswi\Controllers'],
    static function ($routes) {
        $routes->get('/', 'Mahasiswi::index');
        $routes->get('add', 'Mahasiswi::add');
        $routes->post('add', 'Mahasiswi::add');
        $routes->get('(:num)/edit', 'Mahasiswi::edit/$1');
        $routes->post('(:num)/edit', 'Mahasiswi::edit/$1');
        $routes->get('(:num)/delete', 'Mahasiswi::delete/$1');
        
        $routes->get('jurusan', 'Jurusan::index');
        $routes->get('jurusan/add', 'Jurusan::add');
        $routes->post('jurusan/add', 'Jurusan::add');
        $routes->get('jurusan/(:num)/edit', 'Jurusan::edit/$1');
        $routes->post('jurusan/(:num)/edit', 'Jurusan::edit/$1');
        $routes->get('jurusan/(:num)/delete', 'Jurusan::delete/$1');
    }
);
