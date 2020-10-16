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
    Route::post('register', 'API\AuthController@register');
    Route::post('reset-password', 'API\AuthController@resetPassword');
    Route::post('refresh', 'API\AuthController@refresh');
    Route::post('user', 'API\AuthController@getUser');
});


Route::group(['middleware' => ['jwt.auth']], function () {
    Route::resource('progress-mingguan', 'API\ProgressController');
    Route::resource('kondisi-jalan', 'API\KondisiJalanController');
    Route::resource('aduan', 'API\AduanController');
    Route::resource('pembangunan', 'API\PembangunanController');
    Route::resource('proyek-kontrak', 'API\ProyekController');
    Route::get('progress-mingguan/status/{status}', 'API\ProgressController@showStatus');
});

Route::fallback(function(){
    return response()->json([
        'status' => 'false',
        'data' => [
            'message' => 'Page Not Found']
        ], 404);
});
