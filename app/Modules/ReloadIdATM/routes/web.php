<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('reload-id-atm')]], function () {
    Route::resource('reload-id-atm', 'ReloadIdAtmController')->except('show');
    // Route::get('email-simba/filter', 'EmailSimbaController@index');
});
