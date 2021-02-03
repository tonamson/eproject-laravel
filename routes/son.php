<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', 'AuthenticateController@getLogin');
    Route::post('login', 'AuthenticateController@postDoLogin')->name('postLogin');
});
