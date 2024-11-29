<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->resource('departamento');

$routes->resource('empleado');

$routes->resource('vacante');
$routes->resource('candidato');
$routes->resource('entrevista');
$routes->resource('salario');
$routes->get('nomina/generar-pdf/(:segment)', 'Nomina::generarPDF/$1');
$routes->resource('nomina');
$routes->resource('licencia');
$routes->resource('tarea');
$routes->resource('evento');
$routes->resource('notificacion');  // Esto crea la ruta para las operaciones CRUD, incluyendo DELETE

#$routes->post('login/postIniciarSesion', 'Login::postIniciarSesion'); // Ruta para iniciar sesión (POST)
#$routes->get('login/cerrarSesion', 'Login::cerrarSesion'); // Ruta para cerrar sesión (GET)

#$routes->get('nomina/generar-pdf/(:segment)', 'Nomina::generarPDF/$1');



#$routes->get('empleado/display/(:any)/(:any)/(:any)', 'Empleado::display/$1/$2/$3');





// Ruta dinámica para cualquier controlador
#$routes->get('/(:any)', 'App\Controllers\\$1::index');
?>

