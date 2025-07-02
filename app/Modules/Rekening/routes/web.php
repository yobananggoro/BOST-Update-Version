<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('rekening')]], function () {
    Route::resource('rekening', 'RekeningController');
    Route::post('rekening/filter', 'RekeningController@index');
    
});

Route::get('rekening-list', 'RekeningController@listRekening');
