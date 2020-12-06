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
Route::get('admin/master/ruas_jalan', 'MasterController@getRuasJalan')->name('admin.master.ruas_jalan');

// {SiteURL}/uptd/*
Route::group(['prefix' => 'uptd'], function () {
    Route::get('/{slug}', 'LandingController@uptd');
});

// {SiteURL}/admin/*
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect(route('monitoring-kontrak'));
    });
    Route::get('pesan', 'LandingController@getPesan');
    Route::get('log', 'LandingController@getLog');


    Route::view('map-dashboard', 'admin.map.map-dashboard');
    // {SiteURL}/admin/monitoring/*
    Route::group(['prefix' => 'monitoring'], function () {
        Route::get('progress-pekerjaan', 'MonitoringController@getProgressPekerjaan');

        Route::view('survey-kondisi-jalan', 'admin.monitoring.survey-kondisi-jalan');
        Route::view('survey-kondisi-jalan/{uptd}', 'admin.monitoring.survey-kondisi-jalan-uptd')->name('kondisiJalanUPTD');
        Route::view('survey-kondisi-jalan/{uptd}/{jalan}', 'admin.monitoring.survey-kondisi-jalan-uptd-detail')->name('kondisiJalanUPTDDetail');

        Route::get('proyek-kontrak', 'ProyekController@getProyekKontrak')->name('monitoring-kontrak');
        // Route::view('proyek-kontrak', 'admin.monitoring.proyek-kontrak')->name('monitoring-kontrak');
        Route::get('proyek-kontrak/status/{status} ', 'MonitoringController@getProyekDetail');
        Route::get('main-dashboard', 'MonitoringController@getMainDashboard');

        Route::get('laporan-kerusakan', 'MonitoringController@getLaporan');
        Route::view('realisasi-keuangan', 'admin.monitoring.realisasi-keuangan');
        Route::view('audit-keuangan', 'admin.monitoring.audit-keuangan');

        Route::get('kemantapan-jalan', 'MonitoringController@getKemantapanJalan');
        // Route::view('kemantapan-jalan-detail', 'admin.monitoring.kemantapan-jalan-detail');
        Route::get('/getSup/{uptd}', 'MonitoringController@getSup');
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
    });

    Route::group(['prefix' => 'disposisi'], function () {
        Route::get('/', 'DisposisiController@getDaftarDisposisi')->name('daftar-disposisi');
        Route::post('create', 'DisposisiController@create')->name('saveInsertDisposisi');

    });
    Route::group(['prefix' => 'master-data'], function () {
        Route::group(['prefix' => 'jembatan'], function () {
            Route::get('/', 'MasterData\JembatanController@index')->name('getMasterJembatan');
            Route::get('edit/{id}', 'MasterData\JembatanController@edit')->name('editJembatan');
            Route::post('create', 'MasterData\JembatanController@store')->name('createJembatan');
            Route::post('update', 'MasterData\JembatanController@update')->name('updateJembatan');
            // Route::get('delete/{id}', 'LandingController@deleteUPTD')->name('deleteLandingUPTD');
            Route::get('delete/{id}', 'MasterData\JembatanController@delete')->name('deleteJembatan');
        });

        Route::group(['prefix' => 'ruas-jalan'], function () {
            Route::get('/', 'MasterData\RuasJalanController@index')->name('getMasterRuasJalan');
            Route::get('edit/{id}', 'MasterData\RuasJalanController@edit')->name('editMasterRuasJalan');
            Route::post('create', 'MasterData\RuasJalanController@create')->name('createMasterRuasJalan');
            Route::post('update', 'MasterData\RuasJalanController@update')->name('updateMasterRuasJalan');
            // Route::get('delete/{id}', 'LandingController@deleteUPTD')->name('deleteLandingUPTD');
            Route::get('delete/{id}', 'MasterData\RuasJalanController@delete')->name('deleteRuasJalan');
        });
        // Route::resource('jembatan', 'MasterData\JembatanController');
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'MasterData\UserController@getUser')->name('getMasterUser');
            // Route::get('edit/{id}', 'LandingController@editUPTD')->name('editLandingUPTD');
            // Route::post('create', 'LandingController@createUPTD')->name('createLandingUPTD');
            // Route::post('update', 'LandingController@updateUPTD')->name('updateLandingUPTD');
            // Route::get('delete/{id}', 'LandingController@deleteUPTD')->name('deleteLandingUPTD');
        });

        Route::group(['prefix' => 'rawanbencana'], function () {
            Route::get('/', 'MasterData\RawanBencanaController@getData')->name('getDataBencana');
            Route::get('edit/{id}', 'MasterData\RawanBencanaController@editData')->name('editDataBencana');
            Route::post('update/{id}', 'MasterData\RawanBencanaController@updateData')->name('updateDataBencana');
            Route::post('create', 'MasterData\RawanBencanaController@createData')->name('createDataBencana');
            Route::get('delete/{id}', 'MasterData\RawanBencanaController@deleteData')->name('deleteDataBencana');
        });
    });
});
Route::get('map/target-realisasi', 'ProyekController@getTargetRealisasiAPI')->name('api.targetrealisasi');
Route::get('map/proyek-kontrak', 'ProyekController@getProyekKontrakAPI')->name('api.proyekkontrak');

Route::get('map/laporan-masyarakat', 'MonitoringController@getLaporanAPI')->name('api.laporan');
Route::get('map/kemantapan-jalan', 'MonitoringController@getKemantapanJalanAPI')->name('api.kemantapanjalan');

Route::post('getSupData', 'MonitoringController@getSupData')->name('getSupData.filter');

Route::view('debug/map-dashboard', 'debug.map-dashboard');
Route::view('debug/map-filter', 'debug.map-filter');
Route::view('coba-map', 'debug.coba-map');
Route::view('map-progress-mingguan', 'debug.map-progress-mingguan');
Route::view('map-ruas-jalan', 'debug.map-ruas-jalan');
