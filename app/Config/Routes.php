<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('tentang', 'Home::about');
$routes->get('program', 'Home::programs');
$routes->get('program/(:segment)', 'Home::programDetail/$1');
$routes->get('gallery', 'Home::gallery');
$routes->get('donasi', 'Home::donation');
$routes->post('donasi/kirim', 'Home::submitDonation');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('logout', 'AuthController::logout');
$routes->get('dashboard', 'DashboardController::user', ['filter' => 'auth']);
$routes->post('dashboard/account', 'DashboardController::updateOwnAccount', ['filter' => 'auth']);
$routes->get('admin', 'DashboardController::admin', ['filter' => 'admin']);
$routes->post('admin/account', 'DashboardController::updateOwnAccount', ['filter' => 'admin']);
$routes->get('admin/programs/(:num)/edit', 'DashboardController::editProgram/$1', ['filter' => 'admin']);
$routes->post('admin/programs', 'DashboardController::saveProgram', ['filter' => 'admin']);
$routes->post('admin/programs/(:num)', 'DashboardController::updateProgram/$1', ['filter' => 'admin']);
$routes->post('admin/programs/(:num)/delete', 'DashboardController::deleteProgram/$1', ['filter' => 'admin']);
$routes->get('admin/galleries/(:num)/edit', 'DashboardController::editGallery/$1', ['filter' => 'admin']);
$routes->post('admin/galleries', 'DashboardController::saveGallery', ['filter' => 'admin']);
$routes->post('admin/galleries/(:num)', 'DashboardController::updateGallery/$1', ['filter' => 'admin']);
$routes->post('admin/galleries/(:num)/delete', 'DashboardController::deleteGallery/$1', ['filter' => 'admin']);
$routes->get('admin/users/(:num)/edit', 'DashboardController::editUser/$1', ['filter' => 'admin']);
$routes->post('admin/users', 'DashboardController::saveUser', ['filter' => 'admin']);
$routes->post('admin/users/(:num)', 'DashboardController::updateUser/$1', ['filter' => 'admin']);
$routes->post('admin/users/(:num)/delete', 'DashboardController::deleteUser/$1', ['filter' => 'admin']);
$routes->post('admin/donations/(:num)/status', 'DashboardController::updateDonationStatus/$1', ['filter' => 'admin']);
$routes->post('payment/midtrans/notify', 'PaymentController::midtransNotification');
$routes->get('payment/finish', 'PaymentController::finish');
