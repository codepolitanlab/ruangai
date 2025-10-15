<?php

helper('heroicsetting');

$routes->group(
    setting_item('Heroicadmin.urlScope') . '/logviewer',
    ['namespace' => 'Logviewer\Controllers'],
    static function ($routes) {
        // Main log viewer page
        $routes->get('/', 'Logviewer::index');
        
        // View specific log file
        $routes->get('view/(:segment)', 'Logviewer::view/$1');
        
        // Download log file
        $routes->get('download/(:segment)', 'Logviewer::download/$1');
        
        // Delete log file
        $routes->post('delete/(:segment)', 'Logviewer::delete/$1');
        
        // Clear all logs
        $routes->post('clear-all', 'Logviewer::clearAll');
        
        // API endpoints for AJAX requests
        $routes->get('api/files', 'Logviewer::getFiles');
        $routes->get('api/content/(:segment)', 'Logviewer::getContent/$1');
        $routes->get('api/search/(:segment)', 'Logviewer::search/$1');
        
        // Extended API endpoints
        $routes->get('api/dashboard', 'Api::dashboard');
        $routes->get('api/file-stats/(:segment)', 'Api::fileStats/$1');
        $routes->get('api/recent-activity', 'Api::recentActivity');
        $routes->post('api/clean-old', 'Api::cleanOld');
        $routes->get('api/export-csv/(:segment)', 'Api::exportCsv/$1');
    }
);