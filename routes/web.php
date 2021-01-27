<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo/get', [\App\Http\Controllers\DemoController::class, 'testGet']);
Route::get('/demo/example-data-get', [\App\Http\Controllers\DemoController::class, 'exampleDataGet']);
Route::post('/demo/post', [\App\Http\Controllers\DemoController::class, 'post']);
