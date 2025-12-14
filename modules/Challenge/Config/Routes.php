<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/challenge',
    ['namespace' => 'Challenge\Controllers'],
    static function ($routes) {
        $routes->get('submissions', 'Submissions::index');
        $routes->get('submissions/detail/(:num)', 'Submissions::detail/$1');
        $routes->post('submissions/approve/(:num)', 'Submissions::approve/$1');
        $routes->post('submissions/reject/(:num)', 'Submissions::reject/$1');
        $routes->post('submissions/validate/(:num)', 'Submissions::validate/$1');
        $routes->get('submissions/download/(:num)/(:any)', 'Submissions::download/$1/$2');
        $routes->get('submissions/export', 'Submissions::export');
    }
);
