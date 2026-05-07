<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('tentang', 'Home::about');
$routes->get('program', 'Home::programs');
$routes->get('kontak', 'Home::contact');
