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
|	https://codeigniter.com/user_guide/general/routing.html
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

// Login default
$route['default_controller']    = 'home';
$route['404_override']          = '';
$route['translate_uri_dashes']  = FALSE;

// Login
$route['login']['get'] = 'login';
$route['login']['post'] = 'login/login';
$route['logout']['get'] = 'login/logout';

$route['/']['post'] = 'home/login_home';

// Usuários
$route['usuarios']['get'] = 'usuarios';
$route['usuarios/(:num)']['get'] = 'usuarios/index/$1';
$route['usuario/update/(:num)']['get'] = 'usuarios/update_page/$1';
$route['usuario/update/(:num)']['post'] = 'usuarios/update_user/$1';
$route['usuarios/status']['post'] = 'usuarios/status';
$route['usuarios/delete']['post'] = 'usuarios/delete';

//Produtos
$route['produtos/register']['get'] = 'produtos/page_register';
$route['produtos/register']['post'] = 'produtos/register';
$route['produtos/(:num)']['get'] = 'produtos/index/$1';
$route['produtos/update/(:num)']['get'] = 'produtos/update_page/$1';
$route['produtos/update/(:num)']['post'] = 'produtos/update_product/$1';
$route['produtos/status']['post'] = 'produtos/status';
$route['produtos/delete']['post'] = 'produtos/delete';

// Comprar
$route['comprar']['get'] = 'comprar';
$route['comprar/fornecedor/(:num)']['get'] = 'comprar/page_for_produtos/$1';
$route['comprar/finalizar']['get'] = 'comprar/finalizar';
$route['comprar/limpar']['get'] = 'comprar/limpar';
$route['meus-pedidos']['get'] = 'comprar/page_pedidos';

// Register
$route['register']['get'] = 'register';
$route['register']['post'] = 'register/register';

//WS
$route['ws/get_pedidos_json']['post'] = 'comprar/get_pedidos_json';

