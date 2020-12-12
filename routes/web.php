<?php

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

Route::get('/', 'LandingController@index')->name('landing');

// Auth::routes();

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::prefix('ajax')->group(function () {
    Route::namespace('Admin')->group(function() {
        Route::post('pejabat-unit', 'PejabatUnitController@getData')->name('admin.pejabatunit.data');
        Route::post('map-kegiatan', 'MapKegiatanController@getData')->name('admin.mapkegiatan.data');
        Route::post('akun', 'AkunController@getDataParent')->name('admin.akun.parent');
        Route::post('akun-rka21', 'AkunController@getAkunRka21')->name('admin.akun.rka21');
        Route::get('sumber-dana', 'SumberDanaController@getData')->name('admin.sumberdana.data');
        Route::post('akun-5/rba', 'AkunController@getAkun5Rba')->name('admin.akun.5.rba');
        Route::post('akun-5/rka', 'AkunController@getAkun5Rka')->name('admin.akun.5.rka');
        Route::get('akun/rba', 'AkunController@getAkunDataRba')->name('admin.akun.rba');
        Route::get('akun/rka', 'AkunController@getAkunDataRka')->name('admin.akun.rka');
        Route::post('rba-1', 'RBA\RBA1Controller@store')->name('admin.rba1.save');
        Route::post('rba-2', 'RBA\RBA221Controller@store')->name('admin.rba2.save');
        Route::post('rba-31', 'RBA\RBA31Controller@store')->name('admin.rba31.save');
        Route::post('rba-32', 'RBA\RBA32Controller@store')->name('admin.rba32.save');
        Route::post('rka-1', 'RKA\RKA1Controller@store')->name('admin.rka1.save');
        Route::post('rka-221', 'RKA\RKA221Controller@store')->name('admin.rka221.save');
        Route::get('ssh', 'SSHController@getData')->name('admin.ssh.data');
    });
});

Route::prefix('blud')->namespace('Admin')->middleware('auth')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('admin', 'AdminController@adminPage')->name('admin.page');
    Route::put('admin', 'AdminController@updateStatus')->name('admin.update_status');
    Route::post('admin/status-anggaran/create', 'StatusAnggaranController@store')->name('admin.status_anggaran.store');
    Route::put('admin/status-anggaran/edit', 'StatusAnggaranController@update')->name('admin.status_anggaran.update');

    Route::get('report', 'ReportController@index')->name('admin.report.index');
    Route::post('report', 'ReportController@report')->name('admin.report.print');
    Route::get('/report/rba/new', 'ReportController@newReportRba');
    Route::get('/report/rba/{id}', 'ReportController@reportRba')->name('admin.report.rba');
    Route::get('/report/rka/{id}', 'ReportController@reportRka')->name('admin.report.rka');
    
    Route::get('hak-akses', 'HakAksesController@index')->name('admin.hak_akses.index');
    Route::get('hak-akses/edit/{id}', 'HakAksesController@edit')->name('admin.hak_akses.edit');
    Route::put('hak-akses/edit/{id}', 'HakAksesController@update')->name('admin.hak_akses.update');

    // utilitas
    Route::prefix('utilitas')->group(function () {
        Route::get('salin-anggaran-rba', 'SalinAnggaranController@rba')->name('admin.salinanggaran.rba');
        Route::post('salin-anggaran-rba', 'SalinAnggaranController@rbaStore')->name('admin.salinanggaran.rba');
        Route::get('salin-anggaran-rka', 'SalinAnggaranController@rka')->name('admin.salinanggaran.rka');
        Route::post('salin-anggaran-rka', 'SalinAnggaranController@rkaStore')->name('admin.salinanggaran.rka');
    });

    // users
    Route::prefix('users')->group(function () {
        Route::get('/', 'UserController@index')->name('admin.users.index');
        Route::get('profile', 'UserController@profile')->name('admin.users.profile');
        Route::put('profile', 'UserController@profileUpdate')->name('admin.users.update_profile');
        Route::put('profile/password', 'UserController@profilePassword')->name('admin.users.profile_password');
        Route::get('buat', 'UserController@create')->name('admin.users.create');
        Route::post('buat', 'UserController@store')->name('admin.users.store');
        Route::get('edit/{id}', 'UserController@edit')->name('admin.users.edit');
        Route::put('edit/{id}', 'UserController@update')->name('admin.users.update');
        Route::put('edit-password/{id}', 'UserController@updatePassword')->name('admin.users.update_password');
        Route::delete('hapus', 'UserController@destroy')->name('admin.users.destroy');
    });

    Route::prefix('organisasi')->group(function () {
        // fungsi
        Route::get('fungsi', 'FungsiController@index')->name('admin.fungsi.index');
        Route::post('fungsi/buat', 'FungsiController@store')->name('admin.fungsi.store');
        Route::put('fungsi/edit', 'FungsiController@update')->name('admin.fungsi.update');
        Route::delete('fungsi/hapus', 'FungsiController@destroy')->name('admin.fungsi.destroy');

        // urusan
        Route::get('urusan', 'UrusanController@index')->name('admin.urusan.index');
        Route::post('urusan/buat', 'UrusanController@store')->name('admin.urusan.store');
        Route::put('urusan/edit', 'UrusanController@update')->name('admin.urusan.update');
        Route::delete('urusan/hapus', 'UrusanController@destroy')->name('admin.urusan.destroy');

        // bidang
        Route::get('bidang', 'BidangController@index')->name('admin.bidang.index');
        Route::post('bidang/buat', 'BidangController@store')->name('admin.bidang.store');
        Route::put('bidang/edit', 'BidangController@update')->name('admin.bidang.update');
        Route::delete('bidang/hapus', 'BidangController@destroy')->name('admin.bidang.destroy');

        // program
        Route::get('program', 'ProgramController@index')->name('admin.program.index');
        Route::post('program/buat', 'ProgramController@store')->name('admin.program.store');
        Route::put('program/edit', 'ProgramController@update')->name('admin.program.update');
        Route::delete('program/hapus', 'ProgramController@destroy')->name('admin.program.destroy');

        // kegiatan
        Route::get('kegiatan', 'KegiatanController@index')->name('admin.kegiatan.index');
        Route::post('kegiatan/buat', 'KegiatanController@store')->name('admin.kegiatan.store');
        Route::put('kegiatan/edit', 'KegiatanController@update')->name('admin.kegiatan.update');
        Route::delete('kegiatan/hapus', 'KegiatanController@destroy')->name('admin.kegiatan.destroy');

        // sub kegiatan
        Route::get('subKegiatan', 'SubKegiatanController@index')->name('admin.subKegiatan.index');
        Route::post('subKegiatan/buat', 'SubKegiatanController@store')->name('admin.subKegiatan.store');
        Route::put('subKegiatan/edit', 'SubKegiatanController@update')->name('admin.subKegiatan.update');
        Route::delete('kegiatan/hapus', 'KegiatanController@destroy')->name('admin.kegiatan.destroy');

        // opd
        Route::get('opd', 'OpdController@index')->name('admin.opd.index');
        Route::post('opd/buat', 'OpdController@store')->name('admin.opd.store');
        Route::put('opd/edit', 'OpdController@update')->name('admin.opd.update');
        Route::delete('opd/hapus', 'OpdController@destroy')->name('admin.opd.destroy');

        // unit kerja
        Route::get('unit-kerja', 'UnitKerjaController@index')->name('admin.unit_kerja.index');
        Route::post('unit-kerja/buat', 'UnitKerjaController@store')->name('admin.unit_kerja.store');
        Route::put('unit-kerja/edit', 'UnitKerjaController@update')->name('admin.unit_kerja.update');
        Route::delete('unit-kerja/hapus', 'UnitKerjaController@destroy')->name('admin.unit_kerja.destroy');

        // pejabat unit
        Route::get('pejabat-unit', 'PejabatUnitController@index')->name('admin.pejabat_unit.index');
        Route::post('pejabat-unit/buat', 'PejabatUnitController@store')->name('admin.pejabat_unit.store');
        Route::put('pejabat-unit/edit', 'PejabatUnitController@update')->name('admin.pejabat_unit.update');
        Route::delete('pejabat-unit/hapus', 'PejabatUnitController@destroy')->name('admin.pejabat_unit.destroy');
    });

    Route::prefix('data-dasar')->group(function () {
        // pejabat daerah
        Route::get('pejabat-daerah', 'PejabatDaerahController@index')->name('admin.pejabat.index');
        Route::post('pejabat-daerah/buat', 'PejabatDaerahController@store')->name('admin.pejabat.store');
        Route::put('pejabat-daerah/edit', 'PejabatDaerahController@update')->name('admin.pejabat.update');
        Route::delete('pejabat-daerah/hapus', 'PejabatDaerahController@destroy')->name('admin.pejabat.destroy');

        // kategori akun
        Route::get('kategori-akun', 'KategoriAkunController@index')->name('admin.kategoriakun.index');
        Route::post('kategori-akun/buat', 'KategoriAkunController@store')->name('admin.kategoriakun.store');
        Route::put('kategori-akun/edit', 'KategoriAkunController@update')->name('admin.kategoriakun.update');
        Route::delete('kategori-akun/hapus', 'KategoriAkunController@destroy')->name('admin.kategoriakun.destroy');  

        // akun
        Route::get('akun', 'AkunController@index')->name('admin.akun.index');
        Route::post('akun/buat', 'AkunController@store')->name('admin.akun.store');
        Route::put('akun/edit', 'AkunController@update')->name('admin.akun.update');
        Route::delete('akun/hapus', 'AkunController@destroy')->name('admin.akun.destroy');

        // pemetaan akun
        Route::get('pemetaan-akun', 'MapAkunController@index')->name('admin.map_akun.index');
        Route::post('pemetaan-akun/buat', 'MapAkunController@store')->name('admin.map_akun.store');
        Route::put('pemetaan-akun/edit', 'MapAkunController@update')->name('admin.map_akun.update');
        Route::delete('pemetaan-akun/hapus', 'MapAkunController@destroy')->name('admin.map_akun.destroy');

        // pemetaan kegiatan
        Route::get('pemetaan-kegiatan', 'MapKegiatanController@index')->name('admin.map_kegiatan.index');
        Route::post('pemetaan-kegiatan/buat', 'MapKegiatanController@store')->name('admin.map_kegiatan.store');
        Route::put('pemetaan-kegiatan/edit', 'MapKegiatanController@update')->name('admin.map_kegiatan.update');
        Route::delete('pemetaan-kegiatan/hapus', 'MapKegiatanController@destroy')->name('admin.map_kegiatan.destroy');

        // pemetaan sub kegiatan
        Route::get('pemetaanSubKegiatan', 'MapSubKegiatanController@index')->name('admin.mapSubKegiatan.index');
        Route::post('pemetaanSubKegiatan/buat', 'MapSubKegiatanController@store')->name('admin.mapSubKegiatan.store');
        Route::put('pemetaanSubKegiatan/edit', 'MapSubKegiatanController@update')->name('admin.mapSubKegiatan.update');
        Route::delete('pemetaan-kegiatan/hapus', 'MapKegiatanController@destroy')->name('admin.map_kegiatan.destroy');

        // sumber dana
        Route::get('sumber-dana', 'SumberDanaController@index')->name('admin.sumber_dana.index');
        Route::post('sumber-dana/buat', 'SumberDanaController@store')->name('admin.sumber_dana.store');
        Route::put('sumber-dana/edit', 'SumberDanaController@update')->name('admin.sumber_dana.update');
        Route::delete('sumber-dana/hapus', 'SumberDanaController@destroy')->name('admin.sumber_dana.destroy');

        // standard satuan harga
        Route::get('ssh', 'SSHController@index')->name('admin.ssh.index');
        Route::post('ssh/buat', 'SSHController@store')->name('admin.ssh.store');
        Route::put('ssh/edit', 'SSHController@update')->name('admin.ssh.update');
        Route::delete('ssh/hapus', 'SSHController@destroy')->name('admin.ssh.destroy');
    });

    Route::prefix('rba')->namespace('RBA')->group(function () {
        // RBA
        Route::get('blud', 'RBAController@index')->name('admin.rba.index');
        
        // RBA 1
        Route::get('1', 'RBA1Controller@index')->name('admin.rba1.index');
        Route::get('1/create', 'RBA1Controller@create')->name('admin.rba1.create');
        Route::post('1/store', 'RBA1Controller@store')->name('admin.rba1.store');
        Route::get('1/edit/{id}', 'RBA1Controller@edit')->name('admin.rba1.edit');
        Route::get('1/edit/pak/{id}', 'RBA1Controller@editPak')->name('admin.rba1.edit_pak');
        Route::put('1/update/{id}', 'RBA1Controller@update')->name('admin.rba1.update');
        Route::put('1/update/pak/{id}', 'RBA1Controller@updatePak')->name('admin.rba1.update_pak');
        Route::delete('1/hapus', 'RBA1Controller@destroy')->name('admin.rba1.destroy');


        // RBA 2.2.1
        Route::get('221', 'RBA221Controller@index')->name('admin.rba2.index');
        Route::get('221/create', 'RBA221Controller@create')->name('admin.rba2.create');
        Route::post('221/store', 'RBA221Controller@store')->name('admin.rba2.store');
        Route::get('221/edit/{id}', 'RBA221Controller@edit')->name('admin.rba221.edit');
        Route::get('221/edit/pak/{id}', 'RBA221Controller@editPak')->name('admin.rba221.edit_pak');
        Route::put('221/update/{id}', 'RBA221Controller@update')->name('admin.rba2.update');
        Route::put('221/update/pak/{id}', 'RBA221Controller@updatePak')->name('admin.rba2.update_pak');
        Route::delete('221/hapus', 'RBA221Controller@destroy')->name('admin.rba2.destroy');

        // RBA 3.1
        Route::get('31', 'RBA31Controller@index')->name('admin.rba31.index');
        Route::get('31/create', 'RBA31Controller@create')->name('admin.rba31.create');
        Route::post('31/store', 'RBA31Controller@store')->name('admin.rba31.store');
        Route::get('31/edit/{id}', 'RBA31Controller@edit')->name('admin.rba31.edit');
        Route::get('31/edit/pak/{id}', 'RBA31Controller@editPak')->name('admin.rba31.edit_pak');
        Route::put('31/update/{id}', 'RBA31Controller@update')->name('admin.rba31.update');
        Route::put('31/update/pak/{id}', 'RBA31Controller@updatePak')->name('admin.rba31.update_pak');
        Route::delete('31/hapus', 'RBA31Controller@destroy')->name('admin.rba31.destroy');

        // RBA 3.2
        Route::get('32', 'RBA32Controller@index')->name('admin.rba32.index');
        Route::get('32/create', 'RBA32Controller@create')->name('admin.rba32.create');
        Route::post('32/store', 'RBA32Controller@store')->name('admin.rba32.store');
        Route::get('32/edit/{id}', 'RBA32Controller@edit')->name('admin.rba32.edit');
        Route::get('32/edit/pak/{id}', 'RBA32Controller@editPak')->name('admin.rba32.edit_pak');
        Route::put('32/update/{id}', 'RBA32Controller@update')->name('admin.rba32.update');
        Route::put('32/update/pak/{id}', 'RBA32Controller@updatePak')->name('admin.rba32.update_pak');
    });

    Route::prefix('rka')->namespace('RKA')->group(function () {
        // RKA
        Route::get('opd', 'RKAController@index')->name('admin.rka.index');

        // RKA 1
        Route::get('1', 'RKA1Controller@index')->name('admin.rka1.index');
        Route::get('1/create', 'RKA1Controller@create')->name('admin.rka1.create');
        Route::post('1/store', 'RKA1Controller@store')->name('admin.rka1.store');
        Route::get('1/edit/{id}', 'RKA1Controller@edit')->name('admin.rka1.edit');
        Route::get('1/edit/pak/{id}', 'RKA1Controller@editPak')->name('admin.rka1.edit_pak');
        Route::put('1/update/{id}', 'RKA1Controller@update')->name('admin.rka1.update');
        Route::put('1/update/pak/{id}', 'RKA1Controller@updatePak')->name('admin.rka1.update_pak');
        Route::delete('1/hapus', 'RKA1Controller@destroy')->name('admin.rka1.destroy');

        // RKA 21
        Route::get('21', 'RKA21Controller@index')->name('admin.rka21.index');
        Route::get('21/create', 'RKA21Controller@create')->name('admin.rka21.create');
        Route::post('21/store', 'RKA21Controller@store')->name('admin.rka21.store');
        Route::get('21/edit/{id}', 'RKA21Controller@edit')->name('admin.rka21.edit');
        Route::get('21/edit/pak/{id}', 'RKA21Controller@editPak')->name('admin.rka21.edit_pak');
        Route::put('21/update/{id}', 'RKA21Controller@update')->name('admin.rka21.update');
        Route::put('21/update/pak/{id}', 'RKA21Controller@updatePak')->name('admin.rka21.update_pak');
        Route::delete('21/hapus', 'RKA21Controller@destroy')->name('admin.rka21.destroy');

        // RKA 221
        Route::get('221', 'RKA221Controller@index')->name('admin.rka221.index');
        Route::get('221/create', 'RKA221Controller@create')->name('admin.rka221.create');
        Route::post('221/store', 'RKA221Controller@store')->name('admin.rka221.store');
        Route::get('221/edit/{id}', 'RKA221Controller@edit')->name('admin.rka221.edit');
        Route::get('221/edit/pak/{id}', 'RKA221Controller@editPak')->name('admin.rka221.edit_pak');
        Route::put('221/update/{id}', 'RKA221Controller@update')->name('admin.rka221.update');
        Route::put('221/update/pak/{id}', 'RKA221Controller@updatePak')->name('admin.rka221.update_pak');
        Route::delete('221/hapus', 'RKA221Controller@destroy')->name('admin.rka221.destroy');
    });
});