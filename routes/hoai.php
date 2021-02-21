<?php


Route::group(['prefix' => 'department'], function () {
    Route::get('/index', 'DepartmentController@index');
});

Route::group(['prefix' => 'staff'], function () {
    Route::get('/index', 'StaffController@index');
});

Route::group(['prefix' => 'deparment'], function () {
    Route::get('/add', 'DepartmentController@add');
});

Route::group(['prefix' => 'deparment'], function () {
    Route::post('/add1', 'DepartmentController@CreateDepartment');
});
