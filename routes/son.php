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
});
