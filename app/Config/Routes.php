<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('admin/login', 'Admin\Auth::login');
$routes->post('admin/login', 'Admin\Auth::login');

$routes->group('admin', ['filter' => 'adminauth'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->post('logout', 'Admin\Auth::logout');

    $routes->get('products', 'Admin\Products::index');
    $routes->get('products/new', 'Admin\Products::create');
    $routes->post('products', 'Admin\Products::store');
    $routes->get('products/(:num)/edit', 'Admin\Products::edit/$1');
    $routes->post('products/(:num)', 'Admin\Products::update/$1');
    $routes->post('products/(:num)/delete', 'Admin\Products::delete/$1');

    $routes->get('categories', 'Admin\Categories::index');
    $routes->get('categories/new', 'Admin\Categories::create');
    $routes->post('categories', 'Admin\Categories::store');
    $routes->get('categories/(:num)/edit', 'Admin\Categories::edit/$1');
    $routes->post('categories/(:num)', 'Admin\Categories::update/$1');
    $routes->post('categories/(:num)/delete', 'Admin\Categories::delete/$1');
});

$routes->post('checkout', 'Checkout::send');
