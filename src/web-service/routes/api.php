<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\AccessRuleController;
use App\Http\Controllers\LogController;
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

Route::group(['middleware' => 'auth'],   function ($router){
    //Non-Resource type routes
    Route::group(['middleware' => 'api'], function ($router){
        Route::post('/team-control', [TeamController::class, 'attach'])->name('team.attach');
        Route::delete('/team-control', [TeamController::class, 'detach'])->name('team.detach');
        Route::post('/lock-control', [LockGroupController::class, 'attach'])->name('lock_group.attach');
        Route::delete('/lock-control', [LockGroupController::class, 'detach'])->name('lock_group.detach');

        Route::post('/rule-control', [AccessRuleController::class, 'attach'])->name('rule.attach');
        Route::delete('/rule-control', [AccessRuleController::class, 'detach'])->name('rule.detach');

        Route::put('/access/{device_key}', [AccessController::class, 'enter'])->name('access.enter');
    });

//RESOURCES
    Route::apiResource('user', UserController::class);
    Route::apiResource('worker', WorkerController::class);
    Route::apiResource('lock', LockController::class);
    Route::apiResource('team', TeamController::class);
    Route::apiResource('access_rule', AccessRuleController::class);
    Route::apiResource('lock_group', LockGroupController::class);
    Route::apiResource('log', LogController::class)->except(['store', 'update', 'destroy']);
});
