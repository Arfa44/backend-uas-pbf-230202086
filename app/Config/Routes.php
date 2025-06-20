<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {
    $routes->resource('pasien', ['controller' => 'Pasien']);
    $routes->resource('obat', ['controller' => 'Obat']);
});


// $routes->group('api', function ($routes) {
//     $routes->group('obat', function ($routes) {
//         $routes->get('/', 'Obat::index');
//         $routes->get('(:num)', 'Obat::show/$1');
//         $routes->post('/', 'Obat::create');
//         $routes->put('(:num)', 'Obat::update/$1');
//         $routes->delete('(:num)', 'Obat::delete/$1');
//     });
//     $routes->group('pasien', function ($routes) {
//         $routes->get('/', 'Pasien::index');
//         $routes->get('(:num)', 'Pasien::show/$1');
//         $routes->post('/', 'Pasien::create');
//         $routes->put('(:num)', 'Pasien::update/$1');
//         $routes->delete('(:num)', 'Pasien::delete/$1');
//     });
// });
