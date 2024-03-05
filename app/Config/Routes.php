<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Vistas
// Apartado de libros

// Libros CRUD
$routes->get('libro/nuevo', 'C_Libros::VLibroCU/');
$routes->get('libros/nuevo', 'C_Libros::VLibroCU/');

// Libros - Capítulos
$routes->get('libro/(:num)', 'C_Libros::VLibro/$1');
$routes->get('libro/(:num)/detalles', 'C_Libros::VLibroCU/$1');
$routes->get('libro/cap/(:num)', 'C_Capítulos::VCapítulo/$1');
$routes->get('libro/(:num)/cap/(:num)/detalles', 'C_Capítulos::VCapítuloCU/$1/$2');
$routes->get('libro/(:num)/cap/nuevo', 'C_Capítulos::VCapítuloCU/$1');


// Libros - Catálogo
$routes->get('libros/', 'C_Libros::VCatálogo/');

// Usuario
$routes->group('usuario', function ($routes){
    $routes->add('(:any)/favoritos', 'C_Libros::VFavoritos');
});
// Usuarios
$routes->group('usuarios', function ($routes){
    $routes->add('nuevo', 'C_Usuarios::UsuarioCU');
    $routes->add('', 'C_Usuarios::index');
    $routes->add('(:any)/favoritos', 'C_Libros::VFavoritos');
});

// Manejo de sesión
$routes->add('registro', 'C_Usuarios::VRegistro');
$routes->add('login', 'C_Usuarios::VLogin');
$routes->add('logout', 'C_Usuarios::VLogout');


// Llamadas back y respuestas JSON
// $routes->post('b/books/', 'C_Libros::Buscar/');
$routes->post('b/libros/', 'C_Libros::JCatálogo');
$routes->post('b/libros/favoritos', 'C_Libros::JFavoritos');
$routes->post('b/libros/favoritos/revisar', 'C_Libros::JRevisarFavoritos');
$routes->post('b/libros/favoritos/agregar', 'C_Libros::JFavoritosC');
$routes->post('b/libros/favoritos/eliminar', 'C_Libros::JFavoritosD');
$routes->post('b/libro/', 'C_Libros::JLibro/');
$routes->post('b/libro/caps', 'C_Capítulos::JCapítulos/');
$routes->post('b/libro/caps/cu', 'C_Capítulos::JCapítuloCU/');
$routes->post('b/libro/cap/detalles', 'C_Capítulos::JCapítuloDetalles/');
$routes->post('b/libro/cap/detalles/u', 'C_Capítulos::JCapítuloDetallesU/');
$routes->post('b/libro/cap/detalles/d', 'C_Capítulos::JCapítuloDetallesD/');
$routes->post('b/idiomas/', 'C_Idiomas::JCatálogo/');
$routes->post('b/libros/cu', 'C_Libros::JLibroCU/');
$routes->post('b/usuarios/cu', 'C_Usuarios::BUsuarioCU/');
$routes->post('b/login/', 'C_Usuarios::BLogin/');
$routes->post('b/logout/', 'C_Usuarios::BLogout/');
$routes->post('b/registro/', 'C_Usuarios::BRegistro/');