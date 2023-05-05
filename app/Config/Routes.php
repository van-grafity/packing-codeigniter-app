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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Welcome::index');
//$routes->get('/home', 'Home::index');

$routes->post('buyer/save', 'Buyer::save');
$routes->get('/buyer/edit/(:segment)', 'Buyer::edit/$1');
$routes->get('/buyer/update/(:segment)', 'Buyer::update/$1');
$routes->delete('buyer/(:num)', 'Buyer::delete/$1');
$routes->get('/buyer/(:any)', 'Buyer::detail/$1');

$routes->get('/purchaseorder', 'PurchaseOrder::index');
$routes->get('/purchaseorder/store', 'PurchaseOrder::store');
$routes->get('/purchaseorder/(:any)', 'PurchaseOrder::detail/$1');

$routes->get('/packinglist', 'PackingList::index');
$routes->get('/packinglist/get_by_po/(:any)', 'PackingList::getByPoId/$1');
$routes->get('/packinglist/get_style_by_po/(:any)', 'PackingList::getStyleByPoId/$1');
$routes->get('/packinglist/(:any)', 'PackingList::detail/$1');
$routes->get('/packinglist/store', 'PackingList::store');



$routes->get('/cartonbarcode', 'CartonBarcode::index');

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

