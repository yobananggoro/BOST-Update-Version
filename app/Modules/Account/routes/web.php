<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('account-balance')]], function () {
    Route::resource('account-balance', 'ABController')->except('create','show','edit','destroy');
    Route::post('account-balance/filter', 'ABController@index');
    Route::post('account-gi', 'GIController@store');
});

// Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('account-gi')]], function () {
//     Route::resource('account-gi', 'GIController')->except('create','show','edit','destroy');
// });

Route::resource('account-gi', 'GIController')->except('create','show','edit','destroy');