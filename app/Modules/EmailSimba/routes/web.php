<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('email-simba')]], function () {
    Route::resource('email-simba', 'EmailSimbaController')->except('show');;
    Route::post('email-simba/filter', 'EmailSimbaController@index');
});
