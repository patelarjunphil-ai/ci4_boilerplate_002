<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

// Admin Routes
$routes->group('admin', ['filter' => 'permission:admin.access'], function ($routes) {
    $routes->get('reports', 'Admin\Reports::index');
    $routes->get('users', 'Admin\Users::index');
});

// POS Routes
$routes->group('pos', ['filter' => 'permission:pos.use'], function ($routes) {
    $routes->get('/', 'POS::index');
});
