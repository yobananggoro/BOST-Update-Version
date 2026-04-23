<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('user-code')]], function () {
    Route::resource('user-code', 'UserCodeController')->except('create','show','edit','destroy');
    Route::get('user-code/reload', 'UserCodeController@reloadCore');
});

Route::get('user-code-list', 'UserCodeController@getList');
