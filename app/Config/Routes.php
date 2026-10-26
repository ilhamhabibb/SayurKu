<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/login', 'Admin::login');
$routes->get('admin/products', 'Admin::products');
$routes->get('admin/add', 'Admin::add');
$routes->post('admin/add', 'Admin::add');
$routes->get('admin/edit/(:num)', 'Admin::edit/$1');
$routes->post('admin/edit/(:num)', 'Admin::edit/$1');
$routes->get('admin/delete/(:num)', 'Admin::delete/$1');
$routes->get('admin/logout', 'Admin::logout');
$routes->post('checkout', 'Checkout::send');
