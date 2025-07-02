<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('simba')]], function () {
    Route::resource('simba', 'SimbaController');
    Route::post('simba/filter', 'SimbaController@index');
});
