<?php


use Illuminate\Support\Facades\Route;

//Department

Route::group(['prefix' => 'deparment'], function () {
    Route::get('/index', 'DepartmentController@index');
    Route::get('/detail', 'DepartmentController@detailDep');
    Route::get('/edit', 'DepartmentController@getEditDep');
    Route::post('/add1', 'DepartmentController@CreateDepartment');
    Route::get('/add', 'DepartmentController@add');
    Route::post('/pedit', 'DepartmentController@postEditDep')->name('postEditDepartment');
});

//Staff

Route::group(['prefix' => 'staff'], function () {
    Route::get('/index', 'StaffController@index');
});

Route::group(['prefix' => 'staff'], function () {
    Route::get('/add', 'StaffController@vaddStaff');
});

Route::group(['prefix' => 'staff'], function () {
    Route::post('/add', 'StaffController@CreateStaff')->name('postAddStaff');
});

Route::group(['prefix' => 'deparment'], function () {
    Route::get('/detail', 'StaffController@getDetail');
});

Route::group(['prefix' => 'deparment'], function () {
    Route::get('/gedit', 'StaffController@getEditStaff');
});

Route::group(['prefix' => 'deparment'], function () {
    Route::post('/pedit', 'StaffController@postEditStaff');
});