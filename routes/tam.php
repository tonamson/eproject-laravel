<?php 
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', 'DashboardController@index');

Route::get('/check-in-gps', 'CheckInOutController@index');

Route::post('/check-in-gps', 'CheckInOutController@create');