<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('profile', 'ProfileController')->name('profile');
    // Route::get('users', 'UsersController')->name('users');
});


Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('users')]], function () {
    Route::resource('users', 'UsersController')->except('show');
    Route::post('users/filter', 'UsersController@index');
    Route::post('users/isAction', 'UsersController@isAction');
    // Route::post('users/unrelease', 'UsersController@unrelease');
});
