<?php

helper('heroicsetting');

/**
 * Endpoint PUBLIK penerima webhook (dipanggil sistem eksternal, tanpa session admin).
 * Format: POST /webhook/receive/{slug-sumber}
 */
$routes->post('webhook/receive/(:segment)', '\Webhook\Controllers\Receiver::receive/$1');

/**
 * Grup admin: {urlScope}/webhook -> ruangpanel/webhook (review riwayat + sumber)
 */
$routes->group(
    setting_item('Heroicadmin.urlScope') . '/webhook',
    ['namespace' => 'Webhook\Controllers'],
    static function ($routes) {
        // Riwayat webhook
        $routes->get('/', 'Webhook::index');
        $routes->post('/', 'Webhook::index');                       // DataTables AJAX
        $routes->get('detail/(:num)', 'Webhook::detail/$1');
        $routes->post('reprocess/(:num)', 'Webhook::reprocess/$1');
        $routes->post('mark-reviewed/(:num)', 'Webhook::markReviewed/$1');
        $routes->post('delete/(:num)', 'Webhook::delete/$1');

        // Sumber webhook (CRUD)
        $routes->get('sources', 'Source::index');
        $routes->post('sources', 'Source::index');                  // DataTables AJAX
        $routes->get('sources/add', 'Source::add');
        $routes->post('sources/add', 'Source::add');
        $routes->get('sources/(:num)/edit', 'Source::edit/$1');
        $routes->post('sources/(:num)/edit', 'Source::edit/$1');
        $routes->get('sources/(:num)/delete', 'Source::delete/$1');
        $routes->post('sources/(:num)/delete', 'Source::delete/$1');
    }
);
