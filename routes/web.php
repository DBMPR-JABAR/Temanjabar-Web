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
Route::get('forced-login/{encrypted_id}', 'AuthController@loginUsingId');

Route::get('paket-pekerjaan', 'LandingController@paketPekerjaan');
Route::get('progress-pekerjaan', 'LandingController@progressPekerjaan');
Route::post('tambah-laporan', 'LandingController@createLaporan');
Route::post('tambah-pesan', 'LandingController@createPesan');
Route::get('admin/master/ruas_jalan', 'MasterController@getRuasJalan')->name('admin.master.ruas_jalan');
Route::get('map/map-dashboard-masyarakat', 'LandingController@mapMasyarakat')->name('landing.map.map-dashboard-masyarakat');


// {SiteURL}/uptd/*
Route::group(['prefix' => 'uptd'], function () {
    Route::get('/{slug}', 'LandingController@uptd');
});

Route::get('user', 'CobaController@index');
Route::get('user/json', 'CobaController@json');

// {SiteURL}/admin/*
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return redirect(route('monitoring-kontrak'));
    });
    Route::get('pesan', 'LandingController@getPesan');
    Route::get('log', 'LandingController@getLog');

    Route::view('map-dashboard', 'admin.map.map-dashboard');
    Route::view('map-dashboard-canggih', 'admin.map.map-dashboard-canggih');
    // {SiteURL}/admin/monitoring/*
    Route::group(['prefix' => 'monitoring'], function () {
        Route::get('progress-pekerjaan', 'MonitoringController@getProgressPekerjaan');

        Route::view('survey-kondisi-jalan', 'admin.monitoring.survey-kondisi-jalan');
        Route::view('survey-kondisi-jalan/{uptd}', 'admin.monitoring.survey-kondisi-jalan-uptd')->name('kondisiJalanUPTD');
        Route::view('survey-kondisi-jalan/{uptd}/{jalan}', 'admin.monitoring.survey-kondisi-jalan-uptd-detail')->name('kondisiJalanUPTDDetail');

        Route::get('kendali-kontrak', 'ProyekController@getKendaliKontrak')->name('monitoring-kontrak');
        Route::get('kendali-kontrak/progress', 'ProyekController@getKendaliKontrakProgress')->name('monitoring-kontrak-progress');
        // Route::view('proyek-kontrak', 'admin.monitoring.proyek-kontrak')->name('monitoring-kontrak');

        Route::get('kendali-kontrak/status/{status} ', 'ProyekController@getProyekStatus')->name('detailProyekKontrak');
        Route::get('kendali-kontrak/detail/{id} ', 'ProyekController@getProyekDetail')->name('detailProyekKontrakID');

        Route::get('main-dashboard', 'MonitoringController@getMainDashboard');

        Route::get('laporan-kerusakan', 'MonitoringController@getLaporan');
        Route::view('realisasi-keuangan', 'admin.monitoring.realisasi-keuangan');
        Route::view('audit-keuangan', 'admin.monitoring.audit-keuangan');

        Route::get('kemantapan-jalan', 'MonitoringController@getKemantapanJalan');
        // Route::view('kemantapan-jalan-detail', 'admin.monitoring.kemantapan-jalan-detail');
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

        // {SiteURL}/admin/landing-page/uptd
        Route::group(['prefix' => 'uptd'], function () {
            Route::get('/', 'LandingController@getUPTD')->name('getLandingUPTD');
            Route::get('edit/{id}', 'LandingController@editUPTD')->name('editLandingUPTD');
            Route::post('create', 'LandingController@createUPTD')->name('createLandingUPTD');
            Route::post('update', 'LandingController@updateUPTD')->name('updateLandingUPTD');
            Route::get('delete/{id}', 'LandingController@deleteUPTD')->name('deleteLandingUPTD');
        });


        // {SiteURL}/admin/landing-page/laporan-masyarakat
        Route::group(['prefix' => 'laporan-masyarakat'], function () {
            Route::get('/', 'LandingController@getLaporanMasyarakat')->name('getLandingLaporanMasyarakat');
            Route::get('detail/{id}', 'LandingController@detailLaporanMasyarakat')->name('detailLandingLaporanMasyarakat');
            Route::get('edit/{id}', 'LandingController@editLaporanMasyarakat')->name('editLandingLaporanMasyarakat');
            Route::post('create', 'LandingController@createLaporanMasyarakat')->name('createLandingLaporanMasyarakat');
            Route::post('update', 'LandingController@updateLaporanMasyarakat')->name('updateLandingLaporanMasyarakat');
            Route::get('delete/{id}', 'LandingController@deleteLaporanMasyarakat')->name('deleteLaporanMasyarakat');
        });
    });

    Route::group(['prefix' => 'disposisi'], function () {
        Route::get('/', 'DisposisiController@getDaftarDisposisi')->name('daftar-disposisi');
        Route::get('masuk', 'DisposisiController@getInboxDisposisi')->name('disposisi-masuk');
        Route::get('tindaklanjut', 'DisposisiController@getDisposisiTindakLanjut')->name('disposisi-tindak-lanjut');
        Route::post('saveDisposisiLevel2', 'DisposisiController@saveDisposisiLevel2')->name('saveDisposisiLevel2');
        Route::get('instruksi', 'DisposisiController@getDaftarDisposisiInstruksi')->name('disposisi-instruksi');
        Route::get('download/{id}', 'DisposisiController@downloadFile')->name('download');
        Route::get('edit/{id}', 'DisposisiController@edit')->name('editDisposisi');

        Route::post('createTindakLanjut', 'DisposisiController@createTindakLanjut')->name('createTindakLanjut');

        Route::post('updateDisposisi', 'DisposisiController@updateDisposisi')->name('updateDisposisi');
        Route::post('create', 'DisposisiController@create')->name('saveInsertDisposisi');
        Route::post('createDisposisiInstruksi', 'DisposisiController@createInstruksi')->name('saveInsertInstruksi');
        Route::get('accepted/{id}', 'DisposisiController@getAcceptedRequest')->name('getAcceptedRequest');
        Route::get('detail/disposisi/{id}', 'DisposisiController@getdetailDisposisi')->name('getdetailDisposisi');

        Route::get('detail/disposisi-instruksi/{id}', 'DisposisiController@getdetailDisposisiInstruksi')->name('getdetailDisposisiInstruksi');
        Route::get('disposisi-instruksi/getData/{id}', 'DisposisiController@getDataDisposisiInstruksi')->name('getDataDisposisiInstruksi');
        Route::post('disposisi-instruksi/update', 'DisposisiController@updateDisposisiInstruksi')->name('saveUpdateInstruksi');
        Route::get('disposisi-instruksi/delete/{id}', 'DisposisiController@deleteDisposisiInstruksi')->name('deleteDisposisiInstruksi');
    });
    Route::group(['prefix' => 'master-data'], function () {
        Route::group(['prefix' => 'jembatan'], function () {
            Route::get('/', 'MasterData\JembatanController@index')->name('getMasterJembatan');
            Route::get('edit/{id}', 'MasterData\JembatanController@edit')->name('editJembatan');
            Route::get('editPhoto/{id}', 'MasterData\JembatanController@editPhoto')->name('editPhotoJembatan');
            Route::get('viewPhoto/{id}', 'MasterData\JembatanController@viewPhoto')->name('viewPhotoJembatan');
            Route::get('add', 'MasterData\JembatanController@add')->name('addJembatan');
            Route::post('create', 'MasterData\JembatanController@store')->name('createJembatan');
            Route::post('update', 'MasterData\JembatanController@update')->name('updateJembatan');
            Route::post('updatePhoto', 'MasterData\JembatanController@updatePhoto')->name('updatePhotoJembatan');
            Route::get('deletePhoto/{id}', 'MasterData\JembatanController@deletePhoto')->name('deletePhotoJembatan');
            Route::get('delPhoto/{id}', 'MasterData\JembatanController@delPhoto')->name('delPhotoJembatan');
            Route::get('delete/{id}', 'MasterData\JembatanController@delete')->name('deleteJembatan');
            Route::get('getTipeBangunan', 'MasterData\JembatanController@getTipeBangunan')->name('getTipeBangunan');
            Route::get('json', 'MasterData\JembatanController@json')->name('getJsonJembatan');
        });

        Route::group(['prefix' => 'ruas-jalan'], function () {
            Route::get('/', 'MasterData\RuasJalanController@index')->name('getMasterRuasJalan');
            Route::get('edit/{id}', 'MasterData\RuasJalanController@edit')->name('editMasterRuasJalan');
            Route::post('create', 'MasterData\RuasJalanController@create')->name('createMasterRuasJalan');
            Route::post('update', 'MasterData\RuasJalanController@update')->name('updateMasterRuasJalan');
            Route::get('delete/{id}', 'MasterData\RuasJalanController@delete')->name('deleteRuasJalan');
            Route::get('getSUP', 'MasterData\RuasJalanController@getSUP')->name('getSUPRuasJalan');
            Route::get('json', 'MasterData\RuasJalanController@json')->name('getJsonRuasJalan');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('role-akses', 'MasterData\UserController@getDaftarRoleAkses')->name('getRoleAkses');
            Route::post('role-akses/create', 'MasterData\UserController@createRoleAkses')->name('createRoleAkses');
            Route::get('role-akses/detail/{id}', 'MasterData\UserController@detailRoleAkses')->name('detailRoleAkses');
            Route::get('role-akses/delete/{id}', 'MasterData\UserController@deleteRoleAkses')->name('deleteRoleAkses');
            Route::get('role-akses/getData/{id}', 'MasterData\UserController@getDataRoleAkses')->name('getDataRoleAkses');
            Route::post('role-akses/updateData', 'MasterData\UserController@updateDataRoleAkses')->name('updateDataRoleAkses');

            Route::get('user-role', 'MasterData\UserController@getDataUserRole')->name('getDataUserRole');
            Route::post('user-role/create', 'MasterData\UserController@createUserRole')->name('createUserRole');
            Route::get('user-role/detail/{id}', 'MasterData\UserController@detailUserRole')->name('detailUserRole');
            Route::get('user-role/getData/{id}', 'MasterData\UserController@getUserRoleData')->name('getUserRoleData');
            Route::post('user-role/updateData', 'MasterData\UserController@updateUserRole')->name('updateUserRole');
            Route::get('user-role/delete/{id}', 'MasterData\UserController@deleteUserRole')->name('deleteUserRole');
            // Route::get('edit/{id}', 'LandingController@editUPTD')->name('editLandingUPTD');
            // Route::post('create', 'LandingController@createUPTD')->name('createLandingUPTD');
            // Route::post('update', 'LandingController@updateUPTD')->name('updateLandingUPTD');
            // Route::get('delete/{id}', 'LandingController@deleteUPTD')->name('deleteLandingUPTD');
            Route::get('/manajemen', 'MasterData\UserController@getUser')->name('getMasterUser');
            Route::get('/manajemen/detail/{id}', 'MasterData\UserController@detailUser')->name('detailMasterUser');
            Route::get('/manajemen/edit/{id}', 'MasterData\UserController@edit')->name('editUser');
            Route::post('/manajemen/create', 'MasterData\UserController@store')->name('createUser');
            Route::post('/manajemen/update', 'MasterData\UserController@update')->name('updateUser');
            Route::get('/manajemen/delete/{id}', 'MasterData\UserController@delete')->name('deleteUser');
        });

        Route::group(['prefix' => 'rawanbencana'], function () {
            Route::get('/', 'MasterData\RawanBencanaController@getData')->name('getDataBencana');
            Route::get('edit/{id}', 'MasterData\RawanBencanaController@editData')->name('editDataBencana');
            Route::post('update/{id}', 'MasterData\RawanBencanaController@updateData')->name('updateDataBencana');
            Route::post('create', 'MasterData\RawanBencanaController@createData')->name('createDataBencana');
            Route::get('delete/{id}', 'MasterData\RawanBencanaController@deleteData')->name('deleteDataBencana');
            Route::get('json', 'MasterData\RawanBencanaController@json')->name('getJsonDataBencana');
            Route::get('getDataSUP/{id}', 'MasterData\RawanBencanaController@getDataSUP')->name('getDataSUP');
            Route::get('getURL/{id}', 'MasterData\RawanBencanaController@getURL');
        });

        Route::group(['prefix' => 'CCTV'], function () {
            Route::get('/', 'MasterData\CCTVController@index')->name('getDataCCTV');
            Route::get('detail/{id}', 'MasterData\CCTVController@detail')->name('detailDataCCTV');
            Route::post('create', 'MasterData\CCTVController@create')->name('createCCTV');
            Route::get('edit/{id}', 'MasterData\CCTVController@edit')->name('editCCTV');
            Route::post('update', 'MasterData\CCTVController@update')->name('updateDataCCTV');
            Route::get('delete/{id}', 'MasterData\CCTVController@delete')->name('deleteDataCCTV');
            Route::get('getDataSUP/{id}', 'MasterData\CCTVController@getDataSUP')->name('getDataCCTVSUP');

        });

        Route::group(['prefix' => 'icon'], function () {
            Route::get('/', 'MasterData\IconController@index');
            Route::post('create', 'MasterData\IconController@create')->name('createIcon');
            Route::get('detail/{id}', 'MasterData\IconController@detail')->name('detailIcon');
            Route::get('edit/{id}', 'MasterData\IconController@edit')->name('detailIcon');
            Route::post('update', 'MasterData\IconController@update')->name('updateIcon');
            Route::get('delete/{id}', 'MasterData\IconController@delete')->name('deleteIcon');
        });
    });

    Route::group(['prefix' => 'input-data'], function () {
        Route::group(['prefix' => 'pekerjaan'], function () {
            Route::get('/', 'InputData\PekerjaanController@getData')->name('getDataPekerjaan');
            Route::get('edit/{id}', 'InputData\PekerjaanController@editData')->name('editDataPekerjaan');
            Route::get('material/{id}', 'InputData\PekerjaanController@materialData')->name('materialDataPekerjaan');
            Route::post('creatematerial/{id}', 'InputData\PekerjaanController@createDataMaterial')->name('createDataMaterialPekerjaan');
            Route::post('updatematerial/{id}', 'InputData\PekerjaanController@updateDataMaterial')->name('updateDataMaterialPekerjaan');
            Route::post('update/{id}', 'InputData\PekerjaanController@updateData')->name('updateDataPekerjaan');
            Route::post('create', 'InputData\PekerjaanController@createData')->name('createDataPekerjaan');
            Route::get('delete/{id}', 'InputData\PekerjaanController@deleteData')->name('deleteDataPekerjaan');
            Route::get('submit/{id}', 'InputData\PekerjaanController@submitData')->name('submitDataPekerjaan');
            Route::get('json', 'InputData\PekerjaanController@json')->name('getJsonDataBencana');
        });

        Route::group(['prefix' => 'progresskerja'], function () {
            Route::get('/', 'InputData\ProgressPekerjaanController@getDataProgress')->name('getDataProgress');
            Route::get('edit/{id}', 'InputData\ProgressPekerjaanController@editDataProgress')->name('editDataProgress');
            Route::post('update/{id}', 'InputData\ProgressPekerjaanController@updateDataProgress')->name('updateDataProgress');
            Route::post('create', 'InputData\ProgressPekerjaanController@createDataProgress')->name('createDataProgress');
            Route::get('delete/{id}', 'InputData\ProgressPekerjaanController@deleteDataProgress')->name('deleteDataProgress');
            Route::get('json', 'InputData\ProgressPekerjaanController@json')->name('json');
        });

        Route::group(['prefix' => 'keuangan'], function () {
            Route::get('/', 'InputData\KeuanganController@index')->name('getKeuangan');
            Route::get('edit/{id}', 'InputData\KeuanganController@edit')->name('editKeuangan');
            Route::post('update', 'InputData\KeuanganController@update')->name('updateKeuangan');
            Route::get('delete/{id}', 'MasterData\PekerjaanController@deleteData')->name('deleteDataBencana');
        });

        Route::group(['prefix' => 'kondisi-jalan'], function () {
            Route::get('/', 'InputData\KondisiJalanController@index')->name('getIDKondisiJalan');
            Route::get('edit/{id}', 'InputData\KondisiJalanController@edit')->name('editIDKondisiJalan');
            Route::get('add', 'InputData\KondisiJalanController@add')->name('addIDKondisiJalan');
            Route::post('create', 'InputData\KondisiJalanController@create')->name('createIDKondisiJalan');
            Route::post('update', 'InputData\KondisiJalanController@update')->name('updateIDKondisiJalan');
            Route::get('delete/{id}', 'InputData\KondisiJalanController@delete')->name('deleteIDKondisiJalan');
            Route::get('getRuasJalan', 'InputData\KondisiJalanController@getRuasJalan')->name('getRuasJalanKJ');
            Route::get('json', 'InputData\KondisiJalanController@getRJ')->name('getRJ');
        });

        Route::group(['prefix' => 'data-paket'], function () {
            Route::get('/', 'InputData\DataPaketController@index')->name('getIDDataPaket');
            Route::get('edit/{id}', 'InputData\DataPaketController@edit')->name('editIDDataPaket');
            Route::post('create', 'InputData\DataPaketController@create')->name('createIDDataPaket');
            Route::get('add', 'InputData\DataPaketController@add')->name('addIDDataPaket');
            Route::post('update', 'InputData\DataPaketController@update')->name('updateIDDataPaket');
            Route::get('delete/{id}', 'InputData\DataPaketController@delete')->name('deleteIDDataPaket');
            Route::get('json', 'InputData\DataPaketController@json')->name('json');
        });

        Route::group(['prefix' => 'rekap'], function () {
            Route::get('/', 'InputData\RekapController@index')->name('getDataRekap');
            Route::get('edit/{id}', 'InputData\RekapController@editData')->name('editDataRekap');
            Route::post('create', 'InputData\RekapController@createData')->name('createDataRekap');
            Route::post('update', 'InputData\RekapController@updateData')->name('updateDataRekap');
            Route::get('delete/{id}', 'InputData\RekapController@deleteData')->name('deleteDataRekap');
            Route::get('json', 'InputData\RekapController@json')->name('json');
        });
    });

    Route::group(['prefix' => 'lapor'], function () {
        Route::get('/', 'LaporController@index')->name('getLapor');
        Route::get('edit/{id}', 'LaporController@edit')->name('editLapor');
        Route::get('/add', 'LaporController@create')->name('addLapor');
        Route::post('/create', 'LaporController@store')->name('createLapor');
        Route::post('update', 'LaporController@update')->name('updateLapor');
        Route::get('delete/{id}', 'LaporController@delete')->name('deleteLapor');
        Route::get('json', 'LaporController@json')->name('getJsonLapor');
    });
});
Route::get('map/target-realisasi', 'ProyekController@getTargetRealisasiAPI')->name('api.targetrealisasi');
Route::get('map/kendali-kontrak', 'ProyekController@getProyekKontrakAPI')->name('api.proyekkontrak');
Route::get('map/proyek-kontrak-progress', 'ProyekController@getProgressProyekKontrakAPI')->name('api.proyekkontrakprogress');

Route::get('map/laporan-masyarakat', 'MonitoringController@getLaporanAPI')->name('api.laporan');
Route::get('map/kemantapan-jalan', 'MonitoringController@getKemantapanJalanAPI')->name('api.kemantapanjalan');

Route::post('getSupData', 'MonitoringController@getSupData')->name('getSupData.filter');


Route::view('debug/mail/disposisi', 'mail.notifikasiDisposisi');
Route::view('debug/mail/tindaklanjut', 'mail.notifikasiTindakLanjut');

Route::view('debug/push-notification', 'debug.push-notif');

Route::get('debug/pushnow', 'API\PushNotifController@debug');

Route::view('debug/map-dashboard', 'debug.map-dashboard');
Route::view('debug/map-filter', 'debug.map-filter');
Route::view('coba-map', 'debug.coba-map');
Route::view('map-progress-mingguan', 'debug.map-progress-mingguan');
Route::view('map-ruas-jalan', 'debug.map-ruas-jalan');

Route::get('debug', 'Backup\DebugController@debug');
