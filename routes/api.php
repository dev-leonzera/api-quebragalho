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

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/refresh', [AuthController::class, 'refresh']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::get('/user', [UserController::class, 'getUser']);
Route::put('/user', [UserController::class, 'updateUser']);
Route::post('/user/avatar', [UserController::class, 'updateAvatar']);
Route::post('/user/favorite', [UserController::class, 'toogleFavorite']);
Route::get('/user/favorites', [UserController::class, 'getFavorites']);

Route::post('/workers/create', [WorkerController::class, 'createWorker']);
Route::get('/workers', [WorkerController::class, 'getWorkers']);
Route::get('/workers/{id}', [WorkerController::class, 'getWorker']);

Route::get('/search', [WorkerController::class, 'search']);
