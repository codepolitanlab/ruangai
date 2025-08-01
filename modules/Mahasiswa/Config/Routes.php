<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/mahasiswa',
    ['namespace' => 'Mahasiswa\Controllers'],
    static function ($routes) {
        $routes->get('/', 'Mahasiswa::index');
        $routes->get('create', 'Mahasiswa::create');
        $routes->post('store', 'Mahasiswa::store');
        $routes->get('edit/(:num)', 'Mahasiswa::edit/$1');
        $routes->post('update/(:num)', 'Mahasiswa::update/$1');
        $routes->get('delete/(:num)', 'Mahasiswa::delete/$1');
        $routes->get('datatables', 'Mahasiswa::datatables');
        $routes->post('datatables', 'Mahasiswa::datatables');
        $routes->get('table', 'Mahasiswa::table');
    }
);
