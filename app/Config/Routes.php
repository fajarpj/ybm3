<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('tentang', 'Home::about');
$routes->get('program', 'Home::programs');
$routes->get('gallery', 'Home::gallery');
$routes->get('donasi', 'Home::donation');
$routes->post('donasi/kirim', 'Home::submitDonation');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('logout', 'AuthController::logout');
$routes->get('dashboard', 'DashboardController::user', ['filter' => 'auth']);
$routes->get('admin', 'DashboardController::admin', ['filter' => 'admin']);
$routes->post('admin/donations/(:num)/status', 'DashboardController::updateDonationStatus/$1', ['filter' => 'admin']);
$routes->post('payment/midtrans/notify', 'PaymentController::midtransNotification');
$routes->get('payment/finish', 'PaymentController::finish');
