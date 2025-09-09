<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//rutas por vista
// Rutas de autenticación (no protegidas)
$routes->get('/', 'IndexController::index');
$routes->get('login', 'AuthController::index');
$routes->post('authenticate', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');
$routes->get('recover', 'AuthController::recover');
$routes->post('recover/send-link', 'AuthController::sendRecoveryLink');
$routes->get('reset-password/(:segment)', 'AuthController::resetPassword/$1');
$routes->post('reset-password/confirm', 'AuthController::resetPasswordConfirm');

// ===============================
// RUTAS PARA ADMINISTRADOR
// ===============================
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'HomeController::index');
    $routes->get('matricula', 'MatriculaController::index');
    $routes->get('usermanagement', 'UserManagementController::index');
    $routes->post('usermanagement/add', 'UserManagementController::addUser');

    $routes->get('usermanagement/edit/(:num)', 'UserManagementController::editUser/$1');
    $routes->get('usermanagement/detail/(:num)', 'UserManagementController::detailUser/$1');
    
    $routes->get('reciclaje', 'ReciclajeController::reporte_reciclaje_general'); // Registrar material reciclado
    $routes->get('reciclaje/buscar/(:segment)', 'ReciclajeController::buscar/$1'); // Guardar reciclaje
        $routes->post('matriculas/store', 'MatriculaController::store'); // guarda en la BD

    $routes->post('reciclaje/save', 'ReciclajeController::save'); // Guardar reciclaje
    $routes->post('usermanagement/update/(:num)', 'UserManagementController::updateUser/$1');
    $routes->post('usermanagement/showComboBox', 'UserManagementController::showComboBox');
    $routes->get('profile', 'ProfileController::index');

    $routes->get('changepassword', 'ChangePasswordController::index');
    $routes->post('changepassword/update', 'ChangePasswordController::updatePassword');
});

// ===============================
// RUTAS PARA ESTUDIANTE
// ===============================
$routes->group('estudiante', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'HomeController::index');
    $routes->get('reporte-reciclaje', 'ReciclajeController::viewEstudiante'); // Ver reciclaje
    $routes->get('profile', 'ProfileController::index_client');
    $routes->post('profile/update', 'ProfileController::updateClient');
    $routes->get('changepassword', 'ChangePasswordController::index');
    $routes->post('changepassword/update', 'ChangePasswordController::update');
    $routes->get('mi-reporte', 'ReciclajeController::reporte_reciclaje');
    $routes->get('profile', 'ProfileController::index');

});

// ===============================
// RUTAS PARA DOCENTE
// ===============================
$routes->group('docente', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'HomeController::index');
    $routes->get('reciclaje', 'ReciclajeController::index'); // Registrar material reciclado
    $routes->get('reciclaje/buscar/(:segment)', 'ReciclajeController::buscar/$1'); // Guardar reciclaje
    $routes->post('reciclaje/guardar', 'ReciclajeController::guardar'); // Guardar reciclaje
    $routes->get('changepassword', 'ChangePasswordController::index');
    $routes->post('changepassword/update', 'ChangePasswordController::update');
    $routes->get('reciclaje/getEstudiantes', 'ReciclajeController::getEstudiantes');
    $routes->post('reciclaje/guardarMateriales', 'ReciclajeController::guardarMateriales');

    $routes->get('profile', 'ProfileController::index');

});

