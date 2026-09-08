<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('jenis-transaksi')]], function () {
    Route::resource('jenis-transaksi', 'JenisTrxController')->except('create','show','edit','destroy');
    Route::get('jenis-transaksi/reload', 'JenisTrxController@reloadCore');
    Route::get('jenis-transaksi-list', 'JenisTrxController@getList');
});

Route::get('jenis-transaksi-kode', 'JenisTrxController@listDropdown');
Route::post('flag-jenistransaksi', 'JenisTrxController@flaging');