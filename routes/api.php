<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return ['pong'=>true];
});

Route::post('/auth/login');
Route::post('/auth/logout');
Route::post('/auth/refresh');
Route::post('/auth/register');

Route::get('/user');
Route::put('/user');
Route::post('/user/avatar');
Route::post('/user/favorite');
Route::get('/user/favorites');

Route::post('/workers/create');
Route::get('/workers');
Route::get('/workers/{id}');

Route::get('/search');
