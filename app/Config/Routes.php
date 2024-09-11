<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->get('/daftar', 'AuthController::daftar');
$routes->post('/daftar', 'AuthController::auth_daftar');
$routes->post('/', 'AuthController::auth_login');
$routes->get('/logout', 'AuthController::logout');
$routes->group('dashboard', function($routes) {
    $routes->get('/', 'Home::index');
    $routes->group('qc_air_botol', function($routes) {
        $routes->get('/', 'QcAirBotol::index');
        $routes->get('fisikokimia', 'QcAirBotol::fisikokimia');
        $routes->get('organoleptik', 'QcAirBotol::organoleptik');
        $routes->get('mikrobiologi', 'QcAirBotol::mikrobiologi');
        $routes->post('qc_air_botol_fisikokimia', 'QcAirBotol::QCAirBotolFisikokimia');
        $routes->post('qc_air_botol_organoleptik', 'QcAirBotol::QCAirBotolOrganoleptik');
        $routes->post('qc_air_botol_mikrobiologi', 'QcAirBotol::QCAirBotolMikrobiologi');
    });
});
