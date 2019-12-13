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

use Illuminate\Support\Facades\DB;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

Route::get('/sqltest', function () {
    return view('sqltest');
});

Route::get('/test', function () {
    dd(App\Facades\Auth::user());
});

Route::get('/password', function () {
    return Hash::make('ilham');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    // Route::get('ajax/users', 'UserController@ajaxIndex');

    Route::get('ajax/karyawan', 'KaryawanController@ajaxIndex');

    // endpoint pada halaman vendor
    Route::get('vendor', 'VendorController@index');
    Route::get('vendor/tambah', 'VendorController@create');
    Route::post('vendor', 'VendorController@store');
    Route::get('vendor/json', 'VendorController@json');
    Route::get('vendor/{id}/edit', 'VendorController@edit');
    Route::put('vendor/{id}', 'VendorController@update');

    Route::put('ajax/vendor/temp/{id}', 'VendorController@tempUpdate');
    Route::delete('ajax/vendor/temp/{id}', 'VendorController@tempDestroy');

    Route::post('vendor/import', 'VendorController@import');
    Route::get('vendor/import', 'VendorController@importConfirmation');

    // endpoint pada halaman purchase order
    Route::get('purchase-order/json', 'PurchaseOrderController@json');
    Route::get('purchase-order', 'PurchaseOrderController@index');
    Route::get('purchase-order/tambah', 'PurchaseOrderController@create');
    // Route::post('purchase-order', 'PurchaseOrderController@store');
    Route::get('purchase-order/{id}/edit', 'PurchaseOrderController@edit');
    Route::put('purchase-order/{id}', 'PurchaseOrderController@update');

    Route::get('/ajax/purchase-order', 'PurchaseOrderController@ajaxIndex');
    Route::post('/ajax/purchase-order', 'PurchaseOrderController@ajaxStore');
    Route::put('ajax/purchase-order/{id}', 'PurchaseOrderController@ajaxUpdate');
    Route::delete('/ajax/purchase-order/{id}', 'PurchaseOrderController@ajaxDestroy');


    Route::get('ajax/item', 'ItemController@ajaxIndex');
    Route::post('ajax/item', 'ItemController@ajaxStore');
    Route::put('ajax/item/{id}', 'ItemController@ajaxUpdate');
    Route::delete('ajax/item/{id}', 'ItemController@ajaxDestroy');
    Route::get('ajax/item/{id}', 'ItemController@ajaxSingle');

    Route::get('ajax/departemen', 'DepartemenController@ajaxIndex');

    // endpoint pada halaman aset
    Route::get('aset/json', 'AsetController@json');
    Route::get('aset/tambah', 'AsetController@create');
    Route::get('aset', 'AsetController@index');
    Route::post('aset', 'AsetController@store');
    Route::get('aset/{id}', 'AsetController@edit');
    Route::put('aset/{id}', 'AsetController@update');

    Route::get('ajax/aset', 'AsetController@ajaxIndex');

    // permintaan pengeluaran barang

    Route::get('permintaan-pengeluaran-barang', 'PermintaanPengeluaranBarangController@index');
    Route::get('permintaan-pengeluaran-barang/tambah', 'PermintaanPengeluaranBarangController@create');
    Route::get('permintaan-pengeluaran-barang/json', 'PermintaanPengeluaranBarangController@json');

    Route::post('ajax/permintaan-pengeluaran-barang', 'PermintaanPengeluaranBarangController@ajaxStore');

    Route::get('ajax-action/get-item-and-stock-for-asset', 'AjaxActionController@getItemAndStockForAsset');
    Route::get('ajax-action/get-item-and-stock-for-pengeluaran-barang', 'AjaxActionController@getItemAndStockForPengeluaranBarang');

    Route::get('user/json', 'UserController@json');
    Route::get('user/tambah', 'UserController@create');
    Route::get('user', 'UserController@index');
    Route::post('user', 'UserController@store');
    Route::get('user/{id}/edit', 'UserController@edit');
    Route::put('user/{id}', 'UserController@update');

    Route::delete('ajax/user/{id}', 'UserController@ajaxDestroy');
});

Route::get('home', 'HomeController@index')->name('home');

Route::post('login', 'AuthController@login');

Route::get('logout', 'AuthController@logout');
