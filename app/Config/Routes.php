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
// $routes->get('/', 'Welcome::index');

$routes->get('/', function(){
    return view('landing-page');
});

$routes->get('home', 'Home::index');
$routes->get('login', 'Login::index');

// Login-out
$routes->get('login', 'Login::index', ['as' => 'login']);
$routes->post('login', 'Login::attemptLogin');
$routes->get('logout', 'Login::logout');

// User
$routes->get('user', 'User::index');
$routes->post('user/save', 'User::createUser');
$routes->get('user/enable/(:num)', 'User::enable/$1');
$routes->get('user/disable/(:num)', 'User::disable/$1');
$routes->put('user/update', 'User::update');
$routes->get('user/edit/(:num)', 'User::edit');
$routes->post('user/delete', 'User::delete');
$routes->get('user/logs', 'User::userLogs', ['as' => 'userlogs']);

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
$routes->group('product', static function ($routes) {
    $routes->get('', 'Product::index', ['as' => 'product']);
    $routes->get('list', 'Product::index_dt', ['as' => 'product_list']);
    $routes->get('detail', 'Product::detail', ['as' => 'product_detail']);
    $routes->post('store', 'Product::store', ['as' => 'product_store']);
    $routes->post('update', 'Product::update', ['as' => 'product_update']);
    $routes->post('delete', 'Product::delete/$1', ['as' => 'product_delete']);
    $routes->post('importexcel', 'Product::importexcel', ['as' => 'product_importexcel']);
});


// Factory
$routes->get('factory', 'Factory::index');
$routes->post('factory/save', 'Factory::save');
$routes->post('factory/update', 'Factory::update/$1');
$routes->post('factory/delete', 'Factory::delete/$1');

// GL
$routes->get('gl', 'Gl::index');
$routes->post('gl/save', 'Gl::save');
$routes->post('gl/update', 'Gl::update/$1');
$routes->post('gl/delete', 'Gl::delete/$1');

// Style
$routes->get('style', 'Style::index');
$routes->post('style/save', 'Style::save');
$routes->post('style/update', 'Style::update/$1');
$routes->post('style/delete', 'Style::delete/$1');

// Pallet
$routes->get('pallet', 'Pallet::index');
$routes->get('pallet/detail', 'Pallet::detail');
$routes->get('pallet/list', 'Pallet::index_dt');
$routes->post('pallet/save', 'Pallet::save');
$routes->post('pallet/update', 'Pallet::update');
$routes->post('pallet/delete', 'Pallet::delete/$1');

// Rack
$routes->group('rack', static function ($routes) {
    $routes->get('', 'Rack::index', ['as' => 'rack']);
    $routes->get('list', 'Rack::index_dt', ['as' => 'rack_list']);
    $routes->get('detail', 'Rack::detail', ['as' => 'rack_detail']);
    $routes->post('save', 'Rack::save', ['as' => 'rack_save']);
    $routes->post('update', 'Rack::update', ['as' => 'rack_update']);
    $routes->post('delete', 'Rack::delete/$1', ['as' => 'rack_delete']);
});

// Packing List
$routes->get('packinglist', 'PackingList::index');
$routes->post('packinglist/store', 'PackingList::store');
$routes->post('packinglist/delete', 'PackingList::delete');
$routes->post('packinglist/update', 'PackingList::update/$1');
$routes->get('packinglist/(:num)', 'PackingList::detail/$1'); //!! =>> Coba Check ini nanti
$routes->post('packinglistcarton/store', 'PackingList::cartonstore');
$routes->get('packinglistcarton/edit', 'PackingList::cartonedit');
$routes->post('packinglistcarton/update', 'PackingList::cartonupdate');
$routes->post('packinglistcarton/delete', 'PackingList::cartondelete');

$routes->group('packinglist', static function ($routes) {
    $routes->get('list', 'PackingList::index_dt',['as' => 'packinglist_list']);
    $routes->get('edit', 'PackingList::edit',['as' => 'packinglist_edit']);
    $routes->get('report/(:num)', "PackingList::report/$1");

});


// Purchase Order
$routes->get('purchaseorder', 'PurchaseOrder::index');
$routes->post('purchaseorder/savePO', 'PurchaseOrder::savePO');
$routes->post('purchaseorder/store', 'PurchaseOrder::store');
$routes->post('purchaseorder/delete', 'PurchaseOrder::delete');
$routes->get('purchaseorder/(:num)', 'PurchaseOrder::detail/$1');
$routes->post('purchaseorder/adddetail', 'PurchaseOrder::adddetail');
$routes->post('purchaseorder/updatedetail', 'PurchaseOrder::updatedetail');
$routes->post('purchaseorder/deletedetail', 'PurchaseOrder::deletedetail');
$routes->post('purchaseorder/importexcel', 'PurchaseOrder::importexcel');

$routes->group('purchaseorder', static function ($routes) {
    $routes->get('list', 'PurchaseOrder::index_dt',['as' => 'purchase_order_list']);
    $routes->get('edit', 'PurchaseOrder::edit',['as' => 'purchase_order_edit']);
    $routes->post('update', 'PurchaseOrder::update',['as' => 'purchase_order_update']);
});



// Carton Barcode
$routes->get('cartonbarcode', 'CartonBarcode::index'); // !! rapihin route ini
$routes->post('cartonbarcode/importexcel', 'CartonBarcode::importexcel');
$routes->get('cartonbarcode/detailcarton', 'CartonBarcode::detailcarton');
$routes->get('cartonbarcode/(:num)', 'CartonBarcode::detail/$1');
$routes->post('cartonbarcode/generatecarton', 'CartonBarcode::generatecarton');

$routes->group('cartonbarcode', static function ($routes) {
    $routes->get('list', 'CartonBarcode::index_dt',['as' => 'cartonbarcode_list']);
    $routes->get('unpack-carton', 'CartonBarcode::unpack_carton',['as' => 'cartonbarcode_unpack_carton']);
    $routes->get('clear-barcode', 'CartonBarcode::clear_barcode',['as' => 'cartonbarcode_clear_barcode']);
    $routes->get('delete-carton', 'CartonBarcode::delete_carton',['as' => 'cartonbarcode_delete_carton']);
});

// Scan and Pack
$routes->get('scanpack', 'Scanpack::index');
$routes->get('scanpack/detailcarton', 'Scanpack::detailcarton');
$routes->post('scanpack/packcarton', 'Scanpack::packcarton');

// Carton Inspection
$routes->get('cartoninspection', 'CartonInspection::index');
$routes->get('cartoninspection/create', 'CartonInspection::create');
$routes->get('cartoninspection/detailcarton', 'CartonInspection::detailcarton');
$routes->post('cartoninspection/store', 'CartonInspection::store');
$routes->get('cartoninspection/detail', 'CartonInspection::detail');
$routes->get('cartoninspection/transfernote/(:num)', 'CartonInspection::transfernote/$1');
$routes->post('cartoninspection/delete', 'CartonInspection::delete');



$routes->group('pallet-transfer', static function ($routes) {
    $routes->get('', 'PalletTransfer::index', ['as' => 'pallet_transfer']);
    $routes->get('list', 'PalletTransfer::index_dt',['as' => 'pallet_transfer_list']);
    $routes->get('detail', 'PalletTransfer::detail',['as' => 'pallet_transfer_detail']);
    $routes->get('create', 'PalletTransfer::create',['as' => 'pallet_transfer_create']);
    $routes->get('pallet-detail', 'PalletTransfer::pallet_detail',['as' => 'pallet_transfer_pallet_detail']);
    $routes->get('carton-detail', 'PalletTransfer::carton_detail',['as' => 'pallet_transfer_carton_detail']);
    $routes->get('(:num)/transfer-note', 'PalletTransfer::transfer_note/$1',['as' => 'pallet_transfer_transfer_note']);
    $routes->get('transfer-note-detail', 'PalletTransfer::transfer_note_detail',['as' => 'pallet_transfer_transfer_note_detail']);
    $routes->get('check-pallet-availablity', 'PalletTransfer::check_pallet_availablity',['as' => 'pallet_transfer_check_pallet_availablity']);
    
    $routes->post('', 'PalletTransfer::store', ['as' => 'pallet_transfer_store']);
    $routes->post('update', 'PalletTransfer::update',['as' => 'pallet_transfer_update']);
    $routes->post('delete', 'PalletTransfer::delete',['as' => 'pallet_transfer_delete']);
    
    $routes->post('transfer-note-store', 'PalletTransfer::transfer_note_store',['as' => 'pallet_transfer_transfer_note_store']);
    $routes->post('transfer-note-update', 'PalletTransfer::transfer_note_update',['as' => 'pallet_transfer_transfer_note_update']);
    $routes->post('transfer-note-delete', 'PalletTransfer::transfer_note_delete',['as' => 'pallet_transfer_transfer_note_delete']);
    $routes->get('(:num)/transfer-note-print', 'PalletTransfer::transfer_note_print/$1',['as' => 'pallet_transfer_transfer_note_print']);

    $routes->get('complate-preparation', 'PalletTransfer::complete_preparation',['as' => 'pallet_transfer_complete_preparation']);
});

$routes->group('pallet-receive', static function ($routes) {
    $routes->get('', 'PalletReceive::index', ['as' => 'pallet_receive']);
    $routes->get('list', 'PalletReceive::index_dt',['as' => 'pallet_receive_list']);
    $routes->get('create', 'PalletReceive::create',['as' => 'pallet_receive_create']);
    $routes->get('pallet-transfer-detail', 'PalletReceive::pallet_transfer_detail',['as' => 'pallet_receive_pallet_transfer_detail']);
    $routes->post('', 'PalletReceive::store',['as' => 'pallet_receive_store']);
});

$routes->group('rack-information', static function ($routes) {
    $routes->get('', 'RackInformation::index', ['as' => 'rack_information']);
    $routes->get('list', 'RackInformation::index_dt', ['as' => 'rack_information_list']);
    $routes->get('remove-pallet', 'RackInformation::remove_pallet', ['as' => 'remove_pallet_from_rack']);
    $routes->get('location-sheet', 'RackInformation::location_sheet', ['as' => 'rack_information_location_sheet']);
    $routes->get('location-sheet-list', 'RackInformation::location_sheet_list', ['as' => 'rack_information_location_sheet_list']);

    $routes->get('location-sheet-print', 'RackInformation::location_sheet_print',['as' => 'rack_information_location_sheet_print']);
});

$routes->group('carton-loading', static function ($routes) {
    $routes->get('', 'CartonLoading::index', ['as' => 'carton_loading']);
    $routes->get('list', 'CartonLoading::index_dt', ['as' => 'carton_loading_list']);
    $routes->get('load-carton', 'CartonLoading::load_carton', ['as' => 'carton_loading_load_carton']);
    $routes->get('create', 'CartonLoading::create', ['as' => 'carton_loading_create']);
    $routes->get('search-carton-by-pallet', 'CartonLoading::search_carton_by_pallet', ['as' => 'carton_loading_search_carton_by_pallet']);
    $routes->post('store', 'CartonLoading::store', ['as' => 'carton_loading_store']);
});



// Log Viewer
$routes->get('logs', "LogViewerController::index");

// Route for Manipulate Database
$routes->group('update-database', ['filter' => 'onlySuperadmin'], static function ($routes) {
    $routes->get('', 'UpdateDatabase::index', ['as' => 'update_database']);
    $routes->get('aero-international-upc', 'UpdateDatabase::aero_international_upc', ['as' => 'update_aero_international_upc']);
    $routes->get('carton-packed-at', 'UpdateDatabase::carton_packed_at', ['as' => 'update_carton_packed_at']);
});

$routes->group('sync-po', static function ($routes) {
    $routes->get('', 'SyncPurchaseOrder::index', ['as' => 'sync_po']);
    $routes->get('detail', 'SyncPurchaseOrder::sync_po_detail', ['as' => 'sync_po_detail']);
});



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
