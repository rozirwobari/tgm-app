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
$routes->get('/lupa-password', 'AuthController::forgot_password');
$routes->post('/auth_forgot', 'AuthController::auth_forgot');
$routes->get('/reset_password/(:any)', 'AuthController::reset_password/$1');
$routes->post('/reset_password', 'AuthController::auth_reset/$1');
// $routes->get('/export_all_excel', 'Home::exportAllToExcel');
$routes->get('/export_all_excel', 'Home::ExportAllExcel');
$routes->get('/manage_account', 'Home::ManageAccount');
$routes->get('/edit_account/(:num)', 'Home::ManageAccountDetail/$1');
$routes->post('/delete_account/(:num)', 'Home::ManageAccountDelete/$1');
$routes->post('/save_account', 'Home::ManageAccountSave');

$routes->group('dashboard', function($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('profile', 'Profile::index');
    $routes->post('profile', 'Profile::saveprofile');
    $routes->group('qc_air_botol', function($routes) {
        $routes->get('/', 'QcAirBotol::index');
        $routes->get('input', 'QcAirBotol::input');
        $routes->post('input', 'QcAirBotol::QCAirBotolInput');
        $routes->get('detail/(:num)', 'QcAirBotol::QCAirBotolDetail/$1');
        $routes->post('update/(:num)', 'QcAirBotol::QCAirBotolUpdate/$1');
        $routes->get('reject/(:num)', 'QcAirBotol::QCAirBotolReject/$1');
        $routes->get('delete/(:num)', 'QcAirBotol::QCAirBotolDelete/$1');
        $routes->get('approve/(:num)', 'QcAirBotol::QCAirBotolApprove/$1');
        $routes->get('export', 'QcAirBotol::QCAirBotolExport');
    });

    $routes->group('qc_air_cup', function($routes) {
        $routes->get('/', 'QcAirCup::index');
        $routes->get('input', 'QcAirCup::input');
        $routes->get('detail/(:num)', 'QcAirCup::QCAirDetail/$1');
        $routes->post('input', 'QcAirCup::QCAirCupInput');
        $routes->post('update/(:num)', 'QcAirCup::QCAirUpdate/$1');
        $routes->get('reject/(:num)', 'QcAirCup::QCAirReject/$1');
        $routes->get('delete/(:num)', 'QcAirCup::QCAirDelete/$1');
        $routes->get('approve/(:num)', 'QcAirCup::QCAirApprove/$1');
        $routes->get('export', 'QcAirCup::QCAirExport');
    });

    $routes->group('qc_air_galon', function($routes) {
        $routes->get('/', 'QcAirGalon::index');
        $routes->get('input', 'QcAirGalon::input');
        $routes->get('detail/(:num)', 'QcAirGalon::QCAirDetail/$1');
        $routes->post('input', 'QcAirGalon::QCAirGalonInput');
        $routes->post('update/(:num)', 'QcAirGalon::QCAirUpdate/$1');
        $routes->get('reject/(:num)', 'QcAirGalon::QCAirReject/$1');
        $routes->get('delete/(:num)', 'QcAirGalon::QCAirDelete/$1');
        $routes->get('approve/(:num)', 'QcAirGalon::QCAirApprove/$1');
        $routes->get('export', 'QcAirGalon::QCAirExport');
    });

    $routes->group('qc_air_baku', function($routes) {
        $routes->get('/', 'QcAirBaku::index');
        $routes->get('input', 'QcAirBaku::input');
        $routes->get('detail/(:num)', 'QcAirBaku::QCAirDetail/$1');
        $routes->post('input', 'QcAirBaku::QCAirBakuInput');
        $routes->post('update/(:num)', 'QcAirBaku::QCAirUpdate/$1');
        $routes->get('reject/(:num)', 'QcAirBaku::QCAirReject/$1');
        $routes->get('delete/(:num)', 'QcAirBaku::QCAirDelete/$1');
        $routes->get('approve/(:num)', 'QcAirBaku::QCAirApprove/$1');
        $routes->get('export', 'QcAirBaku::QCAirExport');
    });
});
