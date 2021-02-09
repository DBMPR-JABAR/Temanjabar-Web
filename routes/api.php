<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('laporan-masyarakat/store', 'API\LaporanMasyarakatController@store');
Route::get('/lap-masyarakat', 'API\LapMasyarakatController@index');


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'API\AuthController@login');
    Route::post('logout', 'API\AuthController@logout');
    Route::post('registerMail', 'API\AuthController@register');
    Route::post('reset-password', 'API\AuthController@resetPasswordMail');
    Route::post('new-password', 'API\AuthController@resetPassword');
    Route::post('refresh', 'API\AuthController@refresh');
    Route::post('user', 'API\AuthController@getUser');

    Route::post('change-password', 'API\AuthController@newPassword');
    Route::post('change-detail','API\AuthController@changeDetail');

    // Login OTP
    Route::post('loginOTP', 'API\AuthController@loginOTP');
    Route::post('verifyOTPLogin', 'API\AuthController@verifyOTPLogin');

    // Register
    Route::post('register', 'API\AuthController@registerOTP');
    Route::post('verifyOTP', 'API\AuthController@verifyOTP');
    Route::post('resendOTPMail', 'API\AuthController@resendOTPMail');
});



Route::group(['middleware' => ['jwt.auth']], function () {
    Route::resource('laporan-masyarakat', 'API\LaporanMasyarakatController');
    Route::get('laporan-masyarakat/getNotifikasiByUserId/{userId}', 'API\LaporanMasyarakatController@getNotifikasiByUserId');

    Route::post('laporan-masyarakat/approve', 'API\LaporanMasyarakatController@approve');
    Route::post('laporan-masyarakat/progress', 'API\LaporanMasyarakatController@createProgress');
    Route::get('laporan-masyarakat/progress/{id}', 'API\LaporanMasyarakatController@getOnProgress');
    Route::get('laporan-masyarakat/status/{status}', 'API\LaporanMasyarakatController@getListLaporan');

    Route::get('utils/petugas', 'API\LaporanMasyarakatController@getPetugas');
    Route::get('utils/lokasi', 'API\LaporanMasyarakatController@getLokasi');
    Route::get('utils/uptd', 'API\LaporanMasyarakatController@getUPTD');
    Route::get('utils/jenis-laporan', 'API\LaporanMasyarakatController@getJenisLaporan');
    Route::get('utils/notifikasi', 'API\LaporanMasyarakatController@getNotifikasi');

    Route::post('perbaikan-jalan', 'API\MapDashboardController@showPerbaikan');
    Route::get('kemantapan-jalan', 'API\RuasJalanController@getKemantapanJalan');
    Route::get('kemantapan-jalan/{id}', 'API\RuasJalanController@getDetailKemantapanJalan');
    Route::get('kemantapan-jalan-rekap', 'API\RuasJalanController@getRekapKemantapanJalan');

    Route::get('proyek-kontrak', 'API\ProyekController@index');
    Route::get('proyek-kontrak/count', 'API\ProyekController@count');
    Route::get('proyek-kontrak/status/{status}', 'API\ProyekController@getByStatus');

});

Route::resource('ruas-jalan', 'API\RuasJalanController');
Route::resource('pembangunan', 'API\PembangunanController');
Route::resource('proyek-kontrak', 'API\ProyekController');
Route::resource('paket-pekerjaan', 'API\PaketController');
Route::resource('progress-mingguan', 'API\ProgressController');
Route::get('progress-mingguan/status/{status}', 'API\ProgressController@showStatus');
Route::get('progress-mingguan/status/{status}/count', 'API\ProgressController@showStatusCount');

Route::get('pembangunan/category/{category}', 'API\PembangunanController@showByType');
Route::get('kemandoran/category/{category}', 'API\KemandoranController@showByType');

Route::post('map/dashboard/sup', 'API\MapDashboardController@getSUP')->name('api.supdata');
Route::post('map/dashboard/filter', 'API\MapDashboardController@filter');
Route::post('map/dashboard/data', 'API\MapDashboardController@getData');
Route::post('map/dashboard/data-proyek', 'API\MapDashboardController@getDataProyek');
Route::post('map/dashboard/jembatan', 'API\MapDashboardController@getJembatan');
Route::post('map/kemantapan-jalan', 'MonitoringController@getKemantapanJalanAPI')->name('api.kemantapanjalan');


Route::resource('vehicle-counting', 'API\VehicleCountingController');

Route::post('save-token', 'API\PushNotifController@saveToken')->name('save-token');
Route::post('send-notification-user', 'API\PushNotifController@sendNotificationUser')->name('send.notification');
Route::post('debug-notification', 'API\PushNotifController@debugNotification')->name('debug.notification');

Route::fallback(function(){
    return response()->json([
        'status' => 'false',
        'data' => [
            'message' => 'Page Not Found']
        ], 404);
});
