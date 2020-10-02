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

Route::post('auth', 'AuthController@loginAPI');
Route::get('user', 'AuthController@getAuthUser')->middleware('jwt.auth');



Route::resource('progress-mingguan', 'API\ProgressController');
Route::resource('kondisi-jalan', 'API\KondisiJalanController');
Route::resource('aduan', 'API\AduanController');
Route::resource('pembangunan', 'API\PembangunanController');

