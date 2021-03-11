<?php

use App\Http\Controllers\JwtAuthController;
use App\Http\Controllers\UserController;
use App\Models\Worker;
use Illuminate\Support\Facades\Route;

//AUTH
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/signup', [JwtAuthController::class, 'register']);
    Route::post('/signin', [JwtAuthController::class, 'login']);
    Route::get('/me', [JwtAuthController::class, 'profile']);
    Route::post('/token-refresh', [JwtAuthController::class, 'refresh']);
    Route::post('/signout', [JwtAuthController::class, 'signout']);
});

//RESOURCES
Route::apiResource('user', UserController::class);
Route::apiResource('worker', Worker::class);
