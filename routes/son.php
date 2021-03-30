<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', 'AuthenticateController@getLogin');
    Route::post('login', 'AuthenticateController@postDoLogin')->name('postLogin');
    Route::get('logout', 'AuthenticateController@getLogout');
});

Route::group(['prefix' => 'contract'], function () {
    Route::get('list','ContractController@getList')->name('getListContract');
    Route::get('create','ContractController@getCreate')->name('getCreateContract');
    Route::get('detail/{id}','ContractController@getDetail')->name('getDetailContract');
    Route::post('save','ContractController@postSave')->name('postSaveContract');
    Route::get('stop/{id?}','ContractController@stopContract')->name('stopContractContract');
    Route::get('delete/{id}','ContractController@getDelete')->name('getDeleteContract');
    Route::get('export-word/{id}','ContractController@exportWord')->name('exportWord');
});

Route::group(['prefix' => 'salary'], function () {
    Route::get('list','SalaryController@getIndex')->name('getIndexSalary');
    Route::get('details','SalaryController@getDetail')->name('getDetailSalary');
    Route::get('create','SalaryController@getCreate')->name('getCreateSalary');
    Route::get('change-status-success/{id?}','SalaryController@getChangeStatusSuccessSalary')->name('getChangeStatusSuccessSalary');
    Route::post('create','SalaryController@postCalculatedSalary')->name('postCalculatedSalary');
    Route::get('delete/{id?}','SalaryController@getDeleteSalary')->name('getDeleteSalary');
});
