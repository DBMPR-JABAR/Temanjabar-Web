<?php

use Illuminate\Support\Facades\Route;

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
    return view('landing.index');
});

// {SiteURL}/uptd/*
Route::group(['prefix' => 'uptd'], function () {
    Route::view('uptd1', 'landing.uptd.uptd1');
});

// {SiteURL}/admin/*
Route::group(['prefix' => 'admin'], function () {
    Route::view('/', 'admin.home');

    // {SiteURL}/admin/monitoring/*
    Route::group(['prefix' => 'monitoring'], function () {
        Route::view('progress-pekerjaan', 'admin.monitoring.progress-pekerjaan');
        Route::view('supervisi-kontrak', 'admin.monitoring.supervisi-kontrak');
        Route::view('laporan-kerusakan', 'admin.monitoring.laporan-kerusakan');
        Route::view('realisasi-keuangan', 'admin.monitoring.realisasi-keuangan');
        Route::view('audit-keuangan', 'admin.monitoring.audit-keuangan');
    });
    
    // {SiteURL}/admin/rekomendasi/*
    Route::group(['prefix' => 'rekomendasi'], function () {
        Route::view('rekomendasi-kontraktor', 'admin.rekomendasi.rekomendasi-kontraktor');
        Route::view('rekomendasi-konsultan', 'admin.rekomendasi.rekomendasi-konsultan');
        Route::view('rekomendasi-perbaikan', 'admin.rekomendasi.rekomendasi-perbaikan');
    });

});

Route::get('/paket_pekerjaan', function () {
    return view('landing.paket_pekerjaan');
});

Route::get('/progress_pekerjaan', function () {
    return view('landing.progress_pekerjaan');
});