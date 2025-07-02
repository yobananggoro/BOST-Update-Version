<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('menu')]], function () {
    Route::resource('menu', 'MenuController')->except('show');;
    Route::post('menu/filter', 'MenuController@index');
});
