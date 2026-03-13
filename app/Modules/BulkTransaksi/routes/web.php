<?php
Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-onetomany')]], function () {
    Route::resource('upload-onetomany', 'BulkOneToManyController')->except('create','show','edit','destroy');
    Route::post('upload-onetomany/validasi', 'BulkOneToManyController@validasi');
    Route::get('upload-onetomany/download/{filename}', 'BulkOneToManyController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-onetomany-ho')]], function () {
    Route::resource('upload-onetomany-ho', 'BulkOneToManyHOController')->except('create','show','edit','destroy');
    Route::post('upload-onetomany-ho/validasi', 'BulkOneToManyHOController@validasi');
    Route::get('upload-onetomany-ho/download/{filename}', 'BulkOneToManyHOController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-manytoone')]], function () {
    Route::resource('upload-manytoone', 'BulkManyToOneController')->except('create','show','edit','destroy');
    Route::post('upload-manytoone/validasi', 'BulkManyToOneController@validasi');
    Route::get('upload-manytoone/download/{filename}', 'BulkManyToOneController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-cheque')]], function () {
    Route::resource('upload-cheque', 'BulkChequeController')->except('create','show','edit','destroy');
    Route::post('upload-cheque/validasi', 'BulkChequeController@validasi');
    Route::get('upload-cheque/download/{filename}', 'BulkChequeController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-manytoone-ho')]], function () {
    Route::resource('upload-manytoone-ho', 'BulkManyToOneHOController')->except('create','show','edit','destroy');
    Route::post('upload-manytoone-ho/validasi', 'BulkManyToOneHOController@validasi');
    Route::get('upload-manytoone-ho/download/{filename}', 'BulkManyToOneHOController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-onetoone')]], function () {
    Route::resource('upload-onetoone', 'BulkOneToOneController')->except('create','show','edit','destroy');
    Route::post('upload-onetoone/validasi', 'BulkOneToOneController@validasi');
    Route::get('upload-onetoone/download/{filename}', 'BulkOneToOneController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-onetoone-ho')]], function () {
    Route::resource('upload-onetoone-ho', 'BulkOneToOneHOController')->except('create','show','edit','destroy');
    Route::post('upload-onetoone-ho/validasi', 'BulkOneToOneHOController@validasi');
    Route::get('upload-onetoone-ho/download/{filename}', 'BulkOneToOneHOController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('upload-manytomany')]], function () {
    Route::resource('upload-manytomany', 'BulkManyToManyController')->except('create','show','edit','destroy');
    Route::post('upload-manytomany/validasi', 'BulkManyToManyController@validasi');
    Route::get('upload-manytomany/download/{filename}', 'BulkManyToManyController@downloadTemplate');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('list-bulkupload')]], function () {
    Route::resource('list-bulkupload', 'ListBulkUploadController')->except('create','show','edit','destroy');
    Route::post('list-bulkupload/filter', 'ListBulkUploadController@listBulk');
    Route::get('list-bulkupload/verify', 'ListBulkUploadController@verify')->name('list-bulkupload.verify');
    Route::get('list-bulkupload/listDetail', 'ListBulkUploadController@listDetail')->name('list-bulkupload.listDetail');
    Route::get('list-bulkupload/pdf', 'ListBulkUploadController@pdf')->name('list-bulkupload.pdf');
    Route::get('list-bulkupload/excel', 'ListBulkUploadController@excel')->name('list-bulkupload.excel');
});

Route::group(['middleware' => ['auth', 'role:' . permitRolesByUri('remote-otorisasibulk')]], function () {
    Route::resource('remote-otorisasibulk', 'RemoteBulkUploadController')->except('create','show','edit','destroy');
    Route::post('remote-otorisasibulk/filter', 'RemoteBulkUploadController@listBulk');
    Route::post('remote-otorisasibulk/approval', 'RemoteBulkUploadController@approval')->name('remote-otorisasibulk.approval');
    Route::get('remote-otorisasibulk/listDetail', 'RemoteBulkUploadController@listDetail')->name('remote-otorisasibulk.listDetail');
});