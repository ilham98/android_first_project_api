<?php

use App\PermintaanPengeluaranBarang;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('checkToken')->get('/news', function (Request $request) {
    return \App\News::all(); 
});

Route::post('refresh-token', 'API\RefreshTokenController@refresh');

Route::get('/news/{id}', function($id) {
    return \App\News::find($id); 
});

Route::post('/login', 'API\AuthController@login');

Route::get('/permintaan-pengeluaran-barang', function() {
    $pengeluaran_barang = PermintaanPengeluaranBarang::orderBy('id', 'desc')->get();
    return $pengeluaran_barang;
});