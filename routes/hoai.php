<?php


Route::group(['prefix' => 'department'], function () {
    Route::get('/index', 'DepartmentController@index');
});

Route::group(['prefix' => 'staff'], function () {
    Route::get('/index', 'StaffController@index');
});