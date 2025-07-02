<?php

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('fingerprint-status')]], function () {
    Route::resource('fingerprint-status', 'FingerstatusController')->except('create','show','edit','destroy');
    Route::post('fingerprint-status/check', 'FingerstatusController@checkFinger');
});
