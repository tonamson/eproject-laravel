<?php
use Illuminate\Support\Facades\Route;

//Department
Route::group(['prefix' => 'deparment'], function () {
    Route::get('/index', 'DepartmentController@index')->name('getListDeparment');
    Route::get('/detail', 'DepartmentController@detailDep')->name('detailDepartment');
    Route::post('/add', 'DepartmentController@CreateDepartment')->name('postAddDepartment');
    Route::get('/add', 'DepartmentController@add')->name('getAddDepartment');
    Route::get('/edit', 'DepartmentController@getEditDep')->name('getEditDepartment');
    Route::post('/edit', 'DepartmentController@postEditDep')->name('postEditDepartment');
    Route::post('/delete', 'DepartmentController@deleteDepartment')->name('getDeleteDepartment');
    Route::get('/undo', 'DepartmentController@listUndo')->name('getUndoDepartment');
    Route::get('/delete', 'DepartmentController@getDeleteDep')->name('getDeleteDep');
    Route::get('/getundo', 'DepartmentController@getUndoDep')->name('getUndoDep');
});

//Staff
Route::group(['prefix' => 'staff'], function () {
    Route::get('/index', 'StaffController@index');
    Route::get('/add', 'StaffController@vaddStaff');
    Route::get('/detail', 'StaffController@getDetail');
    Route::get('/gedit', 'StaffController@getEditStaff');
    Route::post('/pedit', 'StaffController@postEditStaff');
    Route::post('/add', 'StaffController@CreateStaff')->name('postAddStaff');
    Route::get('/view-profile', 'StaffController@viewProfile');
    Route::get('/load-regional', 'StaffController@loadRegional');
});
