<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
});



Route::get('typeroom','TypeRoomController@index')->name('typeroom.index');
Route::post('typeroom/register','TypeRoomController@store')->name('typeroom.store');
Route::put('typeroom/update','TypeRoomController@update')->name('typeroom.update');
Route::put('typeroom/activo','TypeRoomController@activo')->name('typeroom.activo');
Route::put('typeroom/inactivo','TypeRoomController@inactivo')->name('typeroom.inactivo');
Route::get('typeroom/listRoomActive','TypeRoomController@listRoomActive')->name('typeroom.listRoomActive');


Route::get('room','RoomController@index')->name('room.index');
Route::post('room/register','RoomController@store')->name('room.store');
Route::put('room/update','RoomController@update')->name('room.update');
Route::put('room/activo','RoomController@activo')->name('room.activo');
Route::put('room/statebusy','RoomController@statebusy')->name('room.statebusy');
Route::put('room/statefree','RoomController@statefree')->name('room.statefree');
Route::put('room/inactivo','RoomController@inactivo')->name('room.inactivo');
Route::get('room/active','RoomController@listRoomActive')->name('room.listRoomActive');



Route::get('link','LinkController@index')->name('link.index');
Route::post('link/register','LinkController@store')->name('link.store');
Route::put('link/update','LinkController@update')->name('link.update');
Route::put('link/activo','LinkController@activo')->name('link.activo');
Route::put('link/inactivo','LinkController@inactivo')->name('link.inactivo');
Route::get('link/active','LinkController@listLinksActive')->name('link.listLinksActive');

Route::get('customers','CustomersController@index')->name('customers.index');
Route::post('customers/register','CustomersController@store')->name('customers.store');
Route::put('customers/update','CustomersController@update')->name('customers.update');
Route::get('customers/searchClient','CustomersController@searchClient')->name('customers.searchClient');
        
Route::get('worker','WorkerController@index')->name('worker.index');
Route::post('worker/register','WorkerController@store')->name('worker.store');
Route::put('worker/update','WorkerController@update')->name('worker.update');
Route::put('worker/activo','WorkerController@activo')->name('worker.activo');
Route::put('worker/inactivo','WorkerController@inactivo')->name('worker.inactivo');

Route::get('category','CategoryController@index')->name('category.index');
Route::post('category/register','CategoryController@store')->name('category.store');
Route::put('category/update','CategoryController@update')->name('category.update');
Route::put('category/activo','CategoryController@activo')->name('category.activo');
Route::put('category/inactivo','CategoryController@inactivo')->name('category.inactivo');
Route::get('category/active','CategoryController@listCategoryActive')->name('category.listLinksActive');

Route::get('provider','ProviderController@index')->name('provider.index');
Route::post('provider/register','ProviderController@store')->name('provider.store');
Route::put('provider/update','ProviderController@update')->name('provider.update');
Route::put('provider/activo','ProviderController@activo')->name('provider.activo');
Route::put('provider/inactivo','ProviderController@inactivo')->name('provider.inactivo');
Route::get('provider/active','ProviderController@listProviderActive')->name('provider.listProvidersActive');

Route::get('product','ProductController@index')->name('product.index');
Route::post('product/register','ProductController@store')->name('product.store');
Route::put('product/update','ProductController@update')->name('product.update');
Route::put('product/activo','ProductController@activo')->name('product.activo');
Route::put('product/inactivo','ProductController@inactivo')->name('product.inactivo');
Route::get('product/active','ProductController@listProductActive')->name('v.listproductsActive');

Route::get('certificate','CertificateController@index')->name('certificate.index');
Route::post('certificate/register','CertificateController@store')->name('certificate.store');
Route::put('certificate/update','CertificateController@update')->name('certificate.update');
Route::get('certificate/searchcertificate','CertificateController@searchClient')->name('certificate.searchClient');

Route::get('companion','CompanionController@index')->name('companion.index');
Route::post('companion/register','CompanionController@store')->name('companion.store');
Route::put('companion/update','CompanionController@update')->name('companion.update');
Route::get('companion/searchCompanions','CompanionController@searchCompanions')->name('companion.searchCompanions');

Route::get('counter','CounterController@index')->name('counter.index');
Route::put('counter/update','CounterController@update')->name('counter.update');
Route::get('counter/searchCheck','CounterController@searchCheck')->name('counter.searchCheck');
Route::get('counter/searchTicket','CounterController@searchTicket')->name('counter.searchTicket');
Route::get('counter/searchCertificate','CounterController@searchCertificate')->name('counter.searchCertificate');
Route::get('counter/searchReception','CounterController@searchReception')->name('counter.searchReception');
Route::get('counter/searchExt','CounterController@searchExt')->name('counter.searchExt');
