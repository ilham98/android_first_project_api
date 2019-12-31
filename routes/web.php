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

use App\PermintaanPengeluaranBarang;
use Illuminate\Support\Facades\DB;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;

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

Route::group(['middleware' => ['auth', 'roleCheck']], function () {
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
    Route::delete('ajax/vendor/{id}', 'VendorController@ajaxDestroy');

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

    
    Route::delete('ajax/aset/{id}', 'AsetController@ajaxDestroy');

    // permintaan pengeluaran barang

    Route::get('permintaan-pengeluaran-barang', 'PermintaanPengeluaranBarangController@index');
    Route::get('permintaan-pengeluaran-barang/tambah', 'PermintaanPengeluaranBarangController@create');
    Route::get('permintaan-pengeluaran-barang/{id}/edit', 'PermintaanPengeluaranBarangController@edit');
    Route::get('permintaan-pengeluaran-barang/json', 'PermintaanPengeluaranBarangController@json');

    Route::post('ajax/permintaan-pengeluaran-barang', 'PermintaanPengeluaranBarangController@ajaxStore');
    Route::put('ajax/permintaan-pengeluaran-barang/{permintaan_pengeluaran_barang_id}', 'PermintaanPengeluaranBarangController@ajaxUpdate');
    Route::delete('ajax/permintaan-pengeluaran-barang/{permintaan_pengeluaran_barang_id}/', 'PermintaanPengeluaranBarangController@ajaxDestroy');

    Route::post('ajax/permintaan-pengeluaran-barang/{permintaan_pengeluaran_barang_id}/aset/{id}', 'PermintaanPengeluaranBarangController@ajaxAsetStore');
    
    Route::put('ajax/permintaan-pengeluaran-barang/{permintaan_pengeluaran_barang_id}/aset/{id}', 'PermintaanPengeluaranBarangController@ajaxAsetUpdate');
    Route::delete('ajax/permintaan-pengeluaran-barang/{permintaan_pengeluaran_barang_id}/aset/{id}', 'PermintaanPengeluaranBarangController@ajaxAsetDestroy');
    
    Route::get('ajax-action/get-item-and-stock-for-asset', 'AjaxActionController@getItemAndStockForAsset');
    Route::get('ajax-action/get-item-and-stock-for-pengeluaran-barang', 'AjaxActionController@getItemAndStockForPengeluaranBarang');

    Route::get('user/json', 'UserController@json');
    Route::get('user/tambah', 'UserController@create');
    Route::get('user', 'UserController@index');
    Route::post('user', 'UserController@store');
    Route::get('user/{id}/edit', 'UserController@edit');
    Route::put('user/{id}', 'UserController@update');

    Route::delete('ajax/user/{id}', 'UserController@ajaxDestroy');

    Route::get('/tracking-aset/{id}', 'TrackingAsetController@index');

    Route::get('/report/aset', 'Report\AsetReportController@index');
    Route::post('/report/aset/download', 'Report\AsetReportController@download');

    Route::get('/report/purchase-order', 'Report\PurchaseOrderController@index');
    Route::post('/report/purchase-order/download', 'Report\PurchaseOrderController@download');

    Route::get('/report/pengeluaran-barang', 'Report\PengeluaranBarangController@index');
    Route::post('/report/pengeluaran-barang/download', 'Report\PengeluaranBarangController@download');
});

Route::get('ajax/aset', 'AsetController@ajaxIndex');

Route::get('home', 'HomeController@index')->name('home');

Route::post('login', 'AuthController@login');

Route::get('logout', 'AuthController@logout');


Route::get('send-message-test', function() {
    $messaging = (new Firebase\Factory())->createMessaging();

    $message = CloudMessage::withTarget(/* see sections below */)
        ->withNotification(Notification::create('Title', 'Body'))
        ->withData(['key' => 'value']);

    $messaging->send($message);
});

Route::get('send-to-firebase-service-test', function() {
    // $aset = \App\Aset::find(84);

    // $user_ids = \App\User::where('role_id', 3)->get()->map(function($u) {
    //     return $u->id;
    // })->toArray();

    sendNotification(
        "Berita Acara Penyerahan Aset", 
        "Berita Acara Penyerahan Aset", 
        [1,4,5,6,8,9], 
        1,
        65,
        ['data' => ['message' => 'success'], 'status' => 200]
    );
});

Route::get('/mantap', function() {
    return \App\TrackingAset::where('aset_id', 127)->last($id);
});