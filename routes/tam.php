<?php 
use Illuminate\Support\Facades\Route;

Route::middleware(['check_login'])->group(function () {
    
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('index', 'DashboardController@index');
    });

    Route::group(['prefix' => 'check-in-gps'], function () {
        Route::get('/index', 'CheckInOutController@index');

        Route::post('/create', 'CheckInOutController@create');
    });

    Route::group(['prefix' => 'staff-time'], function () {
        Route::get('/index', 'CheckInOutController@show');
    });

    Route::group(['prefix' => 'time-leave'], function () {
        Route::get('/index', 'TimeleaveController@index');

        Route::post('/create', 'TimeleaveController@createTime');

        Route::get('/delete', 'TimeleaveController@deleteTime');

        Route::get('/detail', 'TimeleaveController@detailTime');

        Route::post('/update', 'TimeleaveController@updateTime');
    });
});