<?php



//Department
Route::group(['prefix' => 'department'], function () {
    Route::get('/index', 'DepartmentController@index');
});

Route::group(['prefix' => 'deparment'], function () {
    Route::get('/add', 'DepartmentController@add');
});

Route::group(['prefix' => 'deparment'], function () {
    Route::post('/add1', 'DepartmentController@CreateDepartment');
});

Route::group(['prefix' => 'deparment'], function () {
    Route::get('/edit', 'DepartmentController@getEditDep');
});

// Route::group(['prefix' => 'deparment'], function () {
//     Route::get('/detail', 'DepartmentController@detailDep');
// });


Route::group(['prefix' => 'deparment'], function () {
    Route::get('/detail', 'DepartmentController@detailDep');
});

//Staff

Route::group(['prefix' => 'staff'], function () {
    Route::get('/index', 'StaffController@index');
});

Route::group(['prefix' => 'staff'], function () {
    Route::get('/add', 'StaffController@vaddStaff');
});

Route::group(['prefix' => 'staff'], function () {
    Route::post('/add1', 'StaffController@CreateDepartment');
});

