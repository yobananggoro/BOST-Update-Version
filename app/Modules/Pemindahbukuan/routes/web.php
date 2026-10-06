<?php
Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('onetoone')]], function () {
    Route::resource('onetoone', 'OnetooneController')->except('show', 'edit', 'destroy');
    Route::post('onetoone/validasi', 'OnetooneController@validasi');
    Route::post('onetoone/getype', 'OnetooneController@getype');
    Route::post('onetoone/posting', 'OnetooneController@posting');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('onetomany')]], function () {
    Route::resource('onetomany', 'OnetomanyController')->except('show', 'edit', 'destroy');
    Route::post('onetomany/validasi', 'OnetomanyController@validasi');
    Route::post('onetomany/getype', 'OnetomanyController@getype');
    Route::post('onetomany/posting', 'OnetomanyController@posting');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('manytoone')]], function () {
    Route::resource('manytoone', 'ManytooneController')->except('show', 'edit', 'destroy');
    Route::post('manytoone/validasi', 'ManytooneController@validasi');
    Route::post('manytoone/getype', 'ManytooneController@getype');
    Route::post('manytoone/posting', 'ManytooneController@posting');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('transaksi-list')]], function () {
    Route::resource('transaksi-list', 'TransaksiListController')->except('create', 'edit', 'destroy');
    Route::post('transaksi-list/filter', 'TransaksiListController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('remote-otorisasi')]], function () {
    Route::resource('remote-otorisasi', 'RemoteOtorisasiController')->except('create', 'edit', 'destroy');
    Route::post('remote-otorisasi/approval', 'RemoteOtorisasiController@approval');
    Route::post('remote-otorisasi/filter', 'RemoteOtorisasiController@index');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('report-transaksi')]], function () {
    Route::resource('report-transaksi', 'ReporTransaksiController')->except('create', 'show', 'edit', 'destroy');
    Route::post('report-transaksi/getReport', 'ReporTransaksiController@getReport');
    Route::post('report-transaksi/pdf', 'ReporTransaksiController@pdf');
});

Route::post('cek-status-transaksi', 'TransaksiListController@cekStatusTransaksi');
Route::post('updt-status-transaksi', 'TransaksiListController@updtStatus');
