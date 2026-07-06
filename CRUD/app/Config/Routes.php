<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);

$routes->group('auth', static function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('authenticate', 'Auth::authenticate');
    $routes->get('logout', 'Auth::logout');
});

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    
    $routes->get('dashboard', 'Dashboard::index');
    
<<<<<<< HEAD
    $routes->group('layanan', static function ($routes) {
        $routes->get('/', 'Layanan::index');
        $routes->get('pdf', 'Layanan::pdf');
        $routes->get('create', 'Layanan::create', ['filter' => 'admin']);
        $routes->post('store', 'Layanan::store', ['filter' => 'admin']);
        $routes->get('edit/(:num)', 'Layanan::edit/$1', ['filter' => 'admin']);
        $routes->post('update/(:num)', 'Layanan::update/$1', ['filter' => 'admin']);
        $routes->get('delete/(:num)', 'Layanan::delete/$1', ['filter' => 'admin']);
=======
    $routes->group('jenis-layanan', static function ($routes) {
        $routes->get('/', 'JenisLayanan::index');
        $routes->get('create', 'JenisLayanan::create');
        $routes->post('store', 'JenisLayanan::store');
        $routes->get('edit/(:num)', 'JenisLayanan::edit/$1');
        $routes->post('update/(:num)', 'JenisLayanan::update/$1');
        $routes->get('delete/(:num)', 'JenisLayanan::delete/$1');
        $routes->get('export-pdf', 'JenisLayanan::exportPdf');
>>>>>>> 8c16e9af2020c66a67919ef6e4717465301975bf
    });

    $routes->group('member', static function ($routes) {
        $routes->get('/', 'Member::index');
        $routes->get('create', 'Member::create');
        $routes->post('store', 'Member::store');
        $routes->get('edit/(:num)', 'Member::edit/$1');
        $routes->post('update/(:num)', 'Member::update/$1');
        $routes->get('delete/(:num)', 'Member::delete/$1');
    });

    $routes->group('pesanan', static function ($routes) {
        $routes->get('/', 'Pesanan::index');
        $routes->get('pdf/(:num)', 'Pesanan::pdf/$1');
        $routes->get('create', 'Pesanan::create');
        $routes->post('store', 'Pesanan::store');
        $routes->get('show/(:num)', 'Pesanan::show/$1');
        $routes->post('update-status/(:num)', 'Pesanan::updateStatus/$1');
        $routes->get('delete/(:num)', 'Pesanan::delete/$1');
    });

    $routes->group('cart', static function ($routes) {
<<<<<<< HEAD
        $routes->get('/', 'CartController::index');
        $routes->get('add/(:num)', 'CartController::add/$1');
        $routes->post('update', 'CartController::update');
        $routes->get('remove/(:num)', 'CartController::remove/$1');
        $routes->get('clear', 'CartController::clear');
    });
=======
        $routes->get('/', 'CartController::index');           
        $routes->post('add', 'CartController::add');          
        $routes->post('update', 'CartController::update');    
        $routes->post('remove', 'CartController::remove');    
        $routes->post('destroy', 'CartController::destroy');  
        $routes->get('total', 'CartController::total');       
        $routes->post('checkout', 'CartController::checkout');
    });

    $routes->get('laporan', 'Laporan::index');
>>>>>>> 8c16e9af2020c66a67919ef6e4717465301975bf

    $routes->get('laporan', 'Laporan::index', ['filter' => 'admin']);

    $routes->group('pengaturan', ['filter' => 'admin'], static function ($routes) {
        $routes->get('/', 'Pengaturan::index');
        $routes->post('update', 'Pengaturan::update');
        $routes->get('profile', 'Pengaturan::profile');
        $routes->post('update-profile', 'Pengaturan::updateProfile');
    });
});
