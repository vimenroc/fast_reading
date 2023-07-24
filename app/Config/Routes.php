<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// Vistas
// Apartado de libros

// Libros CRUD
$routes->get('libro/nuevo', 'C_Libros::VNuevo/');
$routes->get('libros/nuevo', 'C_Libros::VNuevo/');

// Libros - Capítulos
$routes->get('libro/(:num)', 'C_Libros::VLibro/$1');
$routes->get('libro/cap/(:num)', 'C_Libros::VCapítulo/$1');
$routes->get('libro/cap/(:num)/detalles', 'C_Libros::VCapítuloDetalles/$1');
$routes->get('libro/(:num)/cap/nuevo', 'C_Libros::VCapítuloNuevo/$1');


// Libros - Catálogo
$routes->get('libros/', 'C_Libros::VCatálogo/');

// Llamadas back y respuestas JSON
// $routes->post('b/books/', 'C_Libros::Buscar/');
$routes->post('b/libros/', 'C_Libros::JCatálogo');
$routes->post('b/libro/', 'C_Libros::JLibro/');
$routes->post('b/libro/caps', 'C_Libros::JCapítulos/');
$routes->post('b/libro/caps/c', 'C_Libros::JCapítulosC/');
$routes->post('b/libro/cap/detalles', 'C_Libros::JCapítuloDetalles/');
$routes->post('b/libro/cap/detalles/u', 'C_Libros::JCapítuloDetallesU/');
$routes->post('b/libro/cap/detalles/d', 'C_Libros::JCapítuloDetallesD/');
$routes->post('b/idiomas/', 'C_Idiomas::JCatálogo/');
$routes->post('b/libros/nuevo', 'C_Libros::JNuevo/');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
