<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('list-currency')]], function () {
    Route::resource('list-currency', 'CurrencyController')->except('create','show','edit','destroy');
    Route::get('list-currency/reload', 'CurrencyController@reloadCore');
    Route::get('list-currency/getList', 'CurrencyController@getList');
});

Route::post('ccy-rates', 'CurrencyController@getRates');
