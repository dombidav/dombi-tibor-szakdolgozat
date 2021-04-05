<?php

use App\Http\Controllers\AccessRuleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\JwtAuthController;
use App\Http\Controllers\LockController;
use App\Http\Controllers\LockGroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
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

Route::group(['middleware' => 'api'], function ($router){
    Route::post('/team/attach', [TeamController::class, 'attach'])->name('team.attach');
    Route::delete('/team/detach', [TeamController::class, 'detach'])->name('team.detach');
});

//RESOURCES
Route::apiResource('user', UserController::class);
Route::apiResource('worker', WorkerController::class);
Route::apiResource('lock', LockController::class);
Route::apiResource('team', TeamController::class);
Route::apiResource('rule', AccessRuleController::class);
Route::apiResource('lock-group', LockGroupController::class);
