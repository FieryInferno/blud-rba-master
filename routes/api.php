<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['api.whitelist']], function () {
    Route::get('/unit-kerja', 'Api\UnitKerjaController@index');
    Route::get('/rba221/{tipe}', 'Api\RBA221Controller@index');
    Route::get('/rba221/status-anggaran/{status}', 'Api\RBA221Controller@statusAnggaran');
    Route::get('/rba221/detail/{id}', 'Api\RBA221Controller@show');
    Route::get('/status', 'Api\StatusController@index');
});
