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


Route::group(['middleware' => ['checkToken']], function () {
    Route::get('permintaan-pengeluaran-barang', 'API\PermintaanPengeluaranBarangController@index');
    Route::get('permintaan-pengeluaran-barang/{id}', 'API\PermintaanPengeluaranBarangController@single');
    Route::post('/logout', 'API\AuthController@logout');
    Route::get('aset', 'API\AsetController@index');
    Route::get('aset-for-teknisi', 'API\AsetController@asetForTeknisiIndex');
    Route::post('aset-for-teknisi/{id}/kontrol-aset', 'API\AsetController@asetForTeknsisiStore');
    Route::post('aset/{id}/komputer', 'API\AsetKomputerController@store');
    Route::get('aset/{id}/komputer', 'API\AsetKomputerController@single');
    Route::delete('aset/{id}/komputer', 'API\AsetKomputerController@destroy');
    Route::get('aset/{id}/komputer/software', 'API\AsetKomputerController@softwareIndex');
    Route::post('aset/{id}/monitor', 'API\AsetMonitorController@store');
    Route::get('aset/{id}/monitor', 'API\AsetMonitorController@single');
    Route::delete('aset/{id}/monitor', 'API\AsetMonitorController@destroy');
    Route::post('aset/{id}/printer', 'API\AsetPrinterController@store');
    Route::get('aset/{id}/printer', 'API\AsetPrinterController@single');
    Route::delete('aset/{id}/printer', 'API\AsetPrinterController@destroy');

    Route::post('aset/{id}/disposisi-kabag-layanan', 'API\AsetController@disposisiKabagLayanan');
    Route::delete('aset/{id}/disposisi-kabag-layanan', 'API\AsetController@disposisiKabagLayananCancel');

    Route::post('aset/{id}/approve-kabag-layanan', 'API\AsetController@approveKabagLayanan');
    Route::post('aset/{id}/reject-kabag-layanan', 'API\AsetController@rejectKabagLayanan');
    Route::delete('aset/{id}/kabag-layanan-cancel', 'API\AsetController@kabagLayananCancel');
    Route::post('aset/mass-action', 'API\AsetController@massActionKabagLayanan');

    Route::post('aset/{id}/disposisi-kepada-user', 'API\AsetController@disposisiUser');
    Route::delete('aset/{id}/disposisi-kepada-user', 'API\AsetController@disposisiUserCancel');

    Route::post('aset/{id}/approve-kepala-unit-kerja', 'API\AsetController@approveKepalaUnitKerja');
    Route::delete('aset/{id}/approve-kepala-unit-kerja', 'API\AsetController@approveKepalaUnitKerjaCancel');


    Route::post('sign/upload/{id}', 'API\SignUploadController@upload');
    Route::delete('serah-terima-barang-cancel/{id}', 'API\SignUploadController@cancel');

    Route::get('notification', 'API\NotificationController@index');
    Route::get('notification/count', 'API\NotificationController@count');
    Route::post('notification/make-read', 'API\NotificationController@read');

    Route::get('teknisi', 'API\TeknisiController@index');

    Route::get('aset/{id}', 'API\AsetController@single');
    Route::post('aset/{id}/teknisi', 'API\AsetController@store');
    Route::post('aset/{id}/teknisi/cancel', 'API\AsetController@cancel');

    Route::get('aset/{id}/tracking', 'API\AsetController@tracking');

    Route::get('karyawan', 'API\KaryawanController@index');
});



Route::get('tipe-monitor', 'API\TipeMonitorController@index');

Route::post('firebase-service-token', function(Request $request) {
    \App\FirebaseMessageServiceToken::firstOrCreate(
        ['token' => $request->token, 'user_id' => $request->user_id],
        ['token' => $request->token, 'user_id' => $request->user_id]
    );

    return response(['message' => 'success'], 200);
});

Route::get('software', 'API\SoftwareController@index');
Route::get('jenis-sistem-operasi', 'API\JenisSistemOperasiController@index');
Route::get('sistem-operasi', 'API\SistemOperasiController@index');
