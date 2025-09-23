<?php

$HeroicadminConfig = config('Heroicadmin');
$scope             = $HeroicadminConfig->urlScope;
$rootPanelUrl      = $HeroicadminConfig->rootPanelUrl;

/** ========================================================/
 * Dashboard Module
 * ======================================================== */
$routes->group(
    $scope,
    ['namespace' => 'Heroicadmin\Modules\Dashboard\Controllers'],
    static function ($routes) use ($scope, $rootPanelUrl) {
        // Redirect root to default module
        $routes->addRedirect('/', $scope . '/' . $rootPanelUrl);

        $routes->get('dashboard', 'Dashboard::index');
    }
);

/** ========================================================/
 * Setting Module
 * ======================================================== */
$routes->group(
    $scope . '/setting',
    ['namespace' => 'Heroicadmin\Modules\Setting\Controllers'],
    static function ($routes) {
        $routes->get('/', 'Setting::index');
        $routes->get('(:any)', 'Setting::index/$1');
        $routes->post('/', 'Setting::save');
        $routes->post('(:any)', 'Setting::save/$1');
    }
);

/** ========================================================/
 * User Module
 * ======================================================== */
$routes->group(
    $scope . '/user',
    ['namespace' => 'Heroicadmin\Modules\User\Controllers'],
    static function ($routes) {
        // Auth
        $routes->get('login', 'Auth::login');
        $routes->post('login', 'Auth::checkLogin');
        $routes->get('logout', 'Auth::logout');

        // User management
        $routes->get('/', 'User::index');
        $routes->get('form', 'User::form');
        $routes->post('form', 'User::save');
        $routes->post('delete', 'User::delete');

        // Role management
        $routes->get('role', 'Role::index');
        $routes->get('role/form', 'Role::form');
        $routes->get('role/form/(:num)', 'Role::form/$1');
        $routes->post('role/form', 'Role::save');
        $routes->get('role/delete/(:num)', 'Role::delete/$1');

        $routes->get('token', 'Token::index'); // List
        $routes->get('token/import', 'Token::import'); // List
        $routes->post('token/generate', 'Token::generate'); // Insert
    }
);
