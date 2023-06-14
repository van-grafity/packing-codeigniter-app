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
$routes->setDefaultController('Welcome');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Login::login');
$routes->get('/', 'Welcome::index');

$routes->get('/home', 'Home::index');
$routes->get('/login', 'Login::index');

// Login-out
$routes->get('login', 'Login::index', ['as' => 'login']);
$routes->post('login', 'Login::attemptLogin');
$routes->get('logout', 'Login::logout');

// Users
$routes->get('users', 'Users::users', ['as' => 'users']); // new
// $routes->get('users/enable/(:num)', 'Auth\UsersController::enable'); // new
// $routes->get('users/edit/(:num)', 'Auth\UsersController::edit'); // new
// $routes->post('users/update-user', 'Auth\UsersController::update'); // new
// $routes->get('users/delete/(:num)', 'Auth\UsersController::delete'); // new
// $routes->post('users/create-user', 'Auth\UsersController::createUser');
// $routes->get('users/logs', 'Auth\UsersController::userLogs', ['as' => 'userlogs']); // new

// Buyer
$routes->get('buyer', 'Buyer::index');
$routes->post('buyer/save', 'Buyer::save');
$routes->post('buyer/update', 'Buyer::update/$1');
$routes->post('buyer/delete', 'Buyer::delete/$1');

// Colour
$routes->get('colour', 'Colour::index');
$routes->post('colour/save', 'Colour::save');
$routes->post('colour/update', 'Colour::update/$1');
$routes->post('colour/delete', 'Colour::delete/$1');

// Category / Product Type
$routes->get('category', 'Category::index');
$routes->post('category/save', 'Category::save');
$routes->post('category/update', 'Category::update/$1');
$routes->post('category/delete', 'Category::delete/$1');

// Product
$routes->get('product', 'Product::index');
$routes->post('product/save', 'Product::save');
$routes->post('product/update', 'Product::update/$1');
$routes->post('product/delete', 'Product::delete/$1');

// Factory
$routes->get('factory', 'Factory::index');
$routes->post('factory/save', 'Factory::save');
$routes->post('factory/update', 'Factory::update/$1');
$routes->post('factory/delete', 'Factory::delete/$1');

// GL
$routes->get('gl', 'GL::index');
$routes->post('gl/save', 'Gl::save');
$routes->post('gl/update', 'Gl::update/$1');
$routes->post('gl/delete', 'Gl::delete/$1');

// Style
$routes->get('style', 'Style::index');
$routes->post('style/save', 'Style::save');
$routes->post('style/update', 'Style::update/$1');
$routes->post('style/delete', 'Style::delete/$1');

// Packing List
$routes->get('packinglist', 'PackingList::index');
$routes->post('packinglist/store', 'PackingList::store');
$routes->post('packinglist/delete', 'PackingList::delete');
$routes->post('packinglist/update', 'PackingList::update/$1');
$routes->get('/packinglist/(:any)', 'PackingList::detail/$1');

// Purchase Order
$routes->get('purchaseorder', 'PurchaseOrder::index');
$routes->get('purchaseorder/store', 'PurchaseOrder::store');
$routes->get('purchaseorder/(:any)', 'PurchaseOrder::detail/$1');
$routes->post('purchaseorder/updatedetail', 'PurchaseOrder::updatedetail');

// Packing List Carton
$routes->post('packinglistcarton/store', 'PackingList::cartonstore');
$routes->get('packinglistcarton/edit', 'PackingList::cartonedit');
$routes->post('packinglistcarton/update', 'PackingList::cartonupdate');
$routes->post('packinglist/cartondelete', 'PackingList::cartondelete');

// Carton Barcode
$routes->get('cartonbarcode', 'CartonBarcode::index');
$routes->get('cartonbarcode/(:num)', 'CartonBarcode::detail/$1');
$routes->get('cartonbarcode/generatecarton', 'CartonBarcode::generatecarton');

// $routes->get('/packinglist/get_by_po/(:any)', 'PackingList::getByPoId/$1');
// $routes->get('/packinglist/get_style_by_po/(:any)', 'PackingList::getStyleByPoId/$1');
// $routes->get('/packinglist/store', 'PackingList::store');

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
