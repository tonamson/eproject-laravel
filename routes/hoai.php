<?php


Route::group(['prefix' => 'department'], function () {
    Route::get('/index', 'DepartmentController@index');
});