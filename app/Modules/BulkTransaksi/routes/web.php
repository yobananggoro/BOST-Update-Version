<?php
Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-onetomany')]], function () {
    Route::resource('upload-onetomany', 'BulkOneToManyController')->except('create','show','edit','destroy');
    Route::post('upload-onetomany/validasi', 'BulkOneToManyController@validasi');
    Route::get('upload-onetomany/download/{filename}', 'BulkOneToManyController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-manytoone')]], function () {
    Route::resource('upload-manytoone', 'BulkManyToOneController')->except('create','show','edit','destroy');
    Route::post('upload-manytoone/validasi', 'BulkManyToOneController@validasi');
    Route::get('upload-manytoone/download/{filename}', 'BulkManyToOneController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-onetoone')]], function () {
    Route::resource('upload-onetoone', 'BulkOneToOneController')->except('create','show','edit','destroy');
    Route::post('upload-onetoone/validasi', 'BulkOneToOneController@validasi');
    Route::get('upload-onetoone/download/{filename}', 'BulkOneToOneController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('list-bulkupload')]], function () {
    Route::resource('list-bulkupload', 'ListBulkUploadController')->except('create','show','edit','destroy');
    Route::post('list-bulkupload/filter', 'ListBulkUploadController@listBulk');
    Route::get('list-bulkupload/verify', 'ListBulkUploadController@verify')->name('list-bulkupload.verify');
    Route::get('list-bulkupload/listDetail', 'ListBulkUploadController@listDetail')->name('list-bulkupload.listDetail');
    Route::get('list-bulkupload/pdf', 'ListBulkUploadController@pdf')->name('list-bulkupload.pdf');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('remote-otorisasibulk')]], function () {
    Route::resource('remote-otorisasibulk', 'RemoteBulkUploadController')->except('create','show','edit','destroy');
    Route::post('remote-otorisasibulk/filter', 'RemoteBulkUploadController@listBulk');
    Route::post('remote-otorisasibulk/approval', 'RemoteBulkUploadController@approval')->name('remote-otorisasibulk.approval');
    Route::get('remote-otorisasibulk/listDetail', 'RemoteBulkUploadController@listDetail')->name('remote-otorisasibulk.listDetail');
});