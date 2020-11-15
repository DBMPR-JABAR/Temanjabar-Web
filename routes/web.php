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
Route::get('login', 'LandingController@login')->name('login');
Route::get('logout', 'AuthController@logout');
Route::get('verify-email/{token}', 'AuthController@verifyEmail');

Route::post('auth', 'AuthController@login');

Route::get('paket-pekerjaan', 'LandingController@paketPekerjaan');
Route::get('progress-pekerjaan', 'LandingController@progressPekerjaan');
Route::post('tambah-laporan', 'LandingController@createLaporan');
Route::post('tambah-pesan', 'LandingController@createPesan');

// {SiteURL}/uptd/*
Route::group(['prefix' => 'uptd'], function () {
    Route::get('uptd1', 'LandingController@uptd');
});

// {SiteURL}/admin/*
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect(route('monitoring-kontrak'));
    });

    Route::view('map-dashboard', 'admin.map.map-dashboard');
    // {SiteURL}/admin/monitoring/*
    Route::group(['prefix' => 'monitoring'], function () {
        Route::view('progress-pekerjaan', 'admin.monitoring.progress-pekerjaan');

        Route::view('survey-kondisi-jalan', 'admin.monitoring.survey-kondisi-jalan');
        Route::view('survey-kondisi-jalan/{uptd}', 'admin.monitoring.survey-kondisi-jalan-uptd')->name('kondisiJalanUPTD');
        Route::view('survey-kondisi-jalan/{uptd}/{jalan}', 'admin.monitoring.survey-kondisi-jalan-uptd-detail')->name('kondisiJalanUPTDDetail');

        Route::get('proyek-kontrak', 'MonitoringController@getProyekKontrak')->name('monitoring-kontrak');
       // Route::view('proyek-kontrak', 'admin.monitoring.proyek-kontrak')->name('monitoring-kontrak');
        Route::get('proyek-kontrak/status/{status} ', 'MonitoringController@getProyekDetail');
        Route::get('main-dashboard', 'MonitoringController@getMainDashboard');

        Route::get('laporan-kerusakan', 'MonitoringController@getLaporan');
        Route::view('realisasi-keuangan', 'admin.monitoring.realisasi-keuangan');
        Route::view('audit-keuangan', 'admin.monitoring.audit-keuangan');
        Route::view('kemantapan-jalan', 'admin.monitoring.kemantapan-jalan');
        Route::get('/getSup/{uptd}','MonitoringController@getSup');
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
            Route::get('/', 'LandingController@getSlideshow')->name('getLandingSlideshow');
            Route::get('edit/{id}', 'LandingController@editSlideshow')->name('editLandingSlideshow');
            Route::post('create', 'LandingController@createSlideshow')->name('createLandingSlideshow');
            Route::post('update', 'LandingController@updateSlideshow')->name('updateLandingSlideshow');
            Route::get('delete/{id}', 'LandingController@deleteSlideshow')->name('deleteLandingSlideshow');
        });

        // {SiteURL}/admin/landing-page/fitur
        Route::group(['prefix' => 'fitur'], function () {
            Route::get('/', 'LandingController@getFitur')->name('getLandingFitur');
            Route::get('edit/{id}', 'LandingController@editFitur')->name('editLandingFitur');
            Route::post('create', 'LandingController@createFitur')->name('createLandingFitur');
            Route::post('update', 'LandingController@updateFitur')->name('updateLandingFitur');
            Route::get('delete/{id}', 'LandingController@deleteFitur')->name('deleteLandingFitur');
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

Route::post('getSupData', 'MonitoringController@getSupData')->name('getSupData.filter');

Route::view('debug/map-dashboard', 'debug.map-dashboard');
Route::view('debug/map-filter', 'debug.map-filter');
Route::view('coba-map', 'debug.coba-map');
Route::view('map-progress-mingguan', 'debug.map-progress-mingguan');
Route::view('map-ruas-jalan', 'debug.map-ruas-jalan');
