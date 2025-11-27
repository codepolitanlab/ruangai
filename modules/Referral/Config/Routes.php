<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/referral',
    ['namespace' => 'Referral\Controllers'],
    static function ($routes) {
    $routes->get('/', 'Referral::index');
    $routes->get('table', 'Referral::table');

    // Withdrawals CRUD
    $routes->get('withdrawals', 'Withdrawal::index');
    $routes->get('withdrawals/table', 'Withdrawal::table');
    $routes->get('withdrawals/form', 'Withdrawal::form');
    $routes->get('withdrawals/form/(:num)', 'Withdrawal::form/$1');
    $routes->post('withdrawals/save', 'Withdrawal::save');
    $routes->post('withdrawals/save/(:num)', 'Withdrawal::save/$1');
    $routes->post('withdrawals/delete/(:num)', 'Withdrawal::delete/$1');
    $routes->get('withdrawals/search-users', 'Withdrawal::searchUsers');
    }
);
