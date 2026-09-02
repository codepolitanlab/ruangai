<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/voucher',
    ['namespace' => 'Voucher\Controllers'],
    static function ($routes) {
        // Penjualan voucher (transaksi berbayar)
        $routes->get('sales', 'Sales::index');

        // Daftar voucher hasil generate internal (CODEPOLITAN)
        $routes->get('generated', 'Generated::index');
        $routes->post('generated/delete', 'Generated::delete');

        // Generate voucher baru
        $routes->get('generate', 'Generate::index');
        $routes->get('generate/batches', 'Generate::batches'); // AJAX: daftar batch per course
        $routes->post('generate/store', 'Generate::store');    // AJAX: simpan generate
    }
);
