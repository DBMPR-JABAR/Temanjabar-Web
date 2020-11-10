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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'API\AuthController@login');
    Route::post('logout', 'API\AuthController@logout');
    Route::post('registerMail', 'API\AuthController@register');
    Route::post('reset-password', 'API\AuthController@resetPasswordMail');
    Route::post('new-password', 'API\AuthController@resetPassword');
    Route::post('refresh', 'API\AuthController@refresh');
    Route::post('user', 'API\AuthController@getUser');

    // Login OTP
    Route::post('loginOTP', 'API\AuthController@loginOTP');
    Route::post('verifyOTPLogin', 'API\AuthController@verifyOTPLogin');

    // Register
    Route::post('register', 'API\AuthController@registerOTP');
    Route::post('verifyOTP', 'API\AuthController@verifyOTP');
    Route::post('resendOTPMail', 'API\AuthController@resendOTPMail');
});


// Route::group(['middleware' => ['jwt.auth']], function () {
// });
Route::resource('kondisi-jalan', 'API\KondisiJalanController');
Route::resource('laporan-masyarakat', 'API\LaporanMasyarakatController');

Route::resource('ruas-jalan', 'API\RuasJalanController');
Route::resource('pembangunan', 'API\PembangunanController');
Route::resource('proyek-kontrak', 'API\ProyekController');
Route::resource('paket-pekerjaan', 'API\PaketController');
Route::resource('progress-mingguan', 'API\ProgressController');
Route::get('progress-mingguan/status/{status}', 'API\ProgressController@showStatus');
Route::get('progress-mingguan/status/{status}/count', 'API\ProgressController@showStatusCount');

Route::resource('jembatan', 'API\JembatanController');
Route::resource('kemandoran', 'API\KemandoranController');
Route::get('pembangunan/category/{category}', 'API\PembangunanController@showByType');
Route::get('kemandoran/category/{category}', 'API\KemandoranController@showByType');

Route::post('map/dashboard/sup', 'API\MapDashboardController@getSUP')->name('api.supdata');
Route::post('map/dashboard/filter', 'API\MapDashboardController@filter');
Route::post('map/dashboard/data', 'API\MapDashboardController@getData');
Route::post('map/dashboard/data-proyek', 'API\MapDashboardController@getDataProyek');

Route::resource('vehicle-counting', 'API\VehicleCountingController');

Route::fallback(function(){
    return response()->json([
        'status' => 'false',
        'data' => [
            'message' => 'Page Not Found']
        ], 404);
});
