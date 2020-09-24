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

// {SiteURL}
Route::get('/', 'LandingController@index');
Route::get('paket-pekerjaan', 'LandingController@paketPekerjaan');
Route::get('progress-pekerjaan', 'LandingController@progressPekerjaan');
Route::post('tambah-laporan', 'LandingController@createLaporan');
Route::post('tambah-pesan', 'LandingController@createPesan');

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

    // {SiteURL}/admin/landing-page/
    Route::group(['prefix' => 'landing-page'], function () {
        // {SiteURL}/admin/landing-page/profil
        Route::group(['prefix' => 'profil'], function () {
            Route::get('/', 'LandingController@getProfil');
            Route::post('update', 'LandingController@updateProfil')->name('updateLandingProfil');
        });

        // {SiteURL}/admin/landing-page/slideshow
        Route::group(['prefix' => 'slideshow'], function () {
            Route::get('/', 'LandingController@getSlideshow');
            Route::get('edit/{id}', 'LandingController@editSlideshow');
            Route::post('create', 'LandingController@createSlideshow');
            Route::post('update', 'LandingController@updateSlideshow');
            Route::get('delete/{id}', 'LandingController@deleteSlideshow');
        });

        // {SiteURL}/admin/landing-page/fitur
        Route::group(['prefix' => 'fitur'], function () {
            Route::get('/', 'LandingController@getFitur');
            Route::get('edit/{id}', 'LandingController@editFitur');
            Route::post('create', 'LandingController@createFitur');
            Route::post('update', 'LandingController@updateFitur');
            Route::get('delete/{id}', 'LandingController@deleteFitur');
        });

        // {SiteURL}/admin/landing-page/uptd
        Route::group(['prefix' => 'uptd'], function () {
            Route::get('/', 'LandingController@getUPTD')->name('getLandingUPTD');
            Route::get('edit/{id}', 'LandingController@editUPTD')->name('editLandingUPTD');
            Route::post('create', 'LandingController@createUPTD')->name('createLandingUPTD');
            Route::post('update', 'LandingController@updateUPTD')->name('updateLandingUPTD');
            Route::get('delete/{id}', 'LandingController@deleteUPTD')->name('deleteLandingUPTD');
        });

        Route::get('pesan', 'LandingController@getPesan');

    });

});
