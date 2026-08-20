<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('kodefikasi')]], function () {
    Route::resource('kodefikasi', 'KodefikasiController')->except(['show','destroy']);
    Route::post('kodefikasi/filter', 'KodefikasiController@getList');
    Route::get('kodefikasi/listDetail', 'KodefikasiController@listDetail')->name('kodefikasi.listDetail');
    Route::post('kodefikasi/update', 'KodefikasiController@update')->name('kodefikasi.update');
    Route::get('kodefikasi/delete', 'KodefikasiController@destroy')->name('kodefikasi.delete');
});

Route::post('kodefikasi-list', 'KodefikasiController@listDropdown');
