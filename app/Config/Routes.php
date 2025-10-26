<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// CUSTOM AUTHENTICATION ROUTES
// We override Shield's default routes with our custom AuthController
// This allows us to add custom email notifications and enhanced UX

// Login routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');

// Registration routes  
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');

// Logout route
$routes->get('logout', 'AuthController::logout');

// Forgot password routes
$routes->get('forgot-password', 'AuthController::forgotPassword');
$routes->post('forgot-password', 'AuthController::forgotPassword');

// Email verification route
$routes->get('verify-email', 'AuthController::verifyEmail');
$routes->post('register-test', 'AuthController::registerTest');
$routes->get('register-simple', 'AuthController::registerSimple');
$routes->post('register-simple', 'AuthController::registerSimple');

// Include Shield's default routes for other functionality
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

// Working registration routes (the main one)
$routes->get('register', 'FinalAuthController::register');
$routes->post('register', 'FinalAuthController::register');
