<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('view-signature')]], function () {
    Route::resource('view-signature', 'SignatureController')->except('create','show','edit','destroy');
    Route::post('view-signature/checkImage', 'SignatureController@checkImageByCIF')->name('checkImage');
});
