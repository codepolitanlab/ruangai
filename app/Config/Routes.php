<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('cobacoba', 'Home::index');


service('auth')->routes($routes);
