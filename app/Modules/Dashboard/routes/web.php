<?php

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', 'DashboardController')->name('home');
    Route::get('home/getdata', 'DashboardController@getData')->name('home/getdata');
    Route::get('home/getdata2', 'DashboardController@getData2')->name('home/getdata2');
    Route::get('home/getdata3', 'DashboardController@getData3')->name('home/getdata3');
    Route::get('home/getdata4', 'DashboardController@getData4')->name('home/getdata4');
    Route::get('home/notifiaread/{str}', 'DashboardController@notifiaread');
    // Route::group(['prefix' => 'api'], function () {
    //     Route::post('chartPembukaanRekening', function (\Illuminate\Http\Request $request) {
    //         $unit_kerja = \Str::contains(auth()->user()->profile->unit_kerja_kode, 'P') ? '' : auth()->user()->profile->unit_kerja_kode;
    //         return \Modules\Dashboard\Entities\Dashboard::pembukaanRekening($request->periode, $unit_kerja);
    //     });
    // });
});
