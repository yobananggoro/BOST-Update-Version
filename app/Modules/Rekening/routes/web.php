<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('rekening')]], function () {
    Route::resource('rekening', 'RekeningController');
    Route::post('rekening/filter', 'RekeningController@index');
    
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('rekening-costcenter')]], function () {
    Route::resource('rekening-costcenter', 'CostcenterController')->except('create','show','edit','destroy');
    Route::get('rekening-costcenter/reload', 'CostcenterController@reloadCore');
    Route::get('rekening-costcenter/list', 'CostcenterController@getList');
});

Route::get('rekening-list', 'RekeningController@listRekening');
