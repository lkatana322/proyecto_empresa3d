<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Cliente';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['dashboard'] = 'admin/dashboard';
$route['cliente/home'] = 'cliente/home';

// Rutas para gestión de usuarios
$route['usuarios'] = 'Usuarios/index';
$route['usuarios/agregar'] = 'Usuarios/agregar';
$route['usuarios/guardar'] = 'Usuarios/guardar';
$route['usuarios/editar/(:num)'] = 'Usuarios/editar/$1';
$route['usuarios/actualizar'] = 'Usuarios/actualizar';
$route['usuarios/eliminar/(:num)'] = 'Usuarios/eliminar/$1';
// Rutas para el controlador Usuarios

$route['auth/logout'] = 'auth/logout';
$route['auth/login'] = 'auth/login';
// Otras rutas...

$route['perfil'] = 'perfil/index';
$route['perfil/actualizar'] = 'perfil/actualizar';
$route['perfil/cambiar_contraseña'] = 'perfil/cambiar_contraseña';

$route['auth/confirmar'] = 'auth/confirmar';
$route['auth/confirmar_action'] = 'auth/confirmar_action';
$route['producto/detalle/(:num)'] = 'cliente/producto_detalle/$1';
$route['cliente/productos/categoria/(:num)'] = 'cliente/productos_por_categoria/$1';

