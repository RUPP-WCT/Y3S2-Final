<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Users\AdminsController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;




Route::prefix('auth')->group(function () {
    Route::middleware(['throttle:10,1'])->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [UsersController::class, 'create']);
    });
});

Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    Route::get('user', [UsersController::class, 'show']);
    Route::post('user', [UsersController::class, 'update']);
});

Route::prefix('admin')->group(function () {
    Route::middleware(['auth:sanctum', 'role:2,3', 'throttle:120,1'])->group(function () {
        Route::get('users', [AdminsController::class, 'index']);
        Route::get('users/{username}', [AdminsController::class, 'show']);
        Route::post('users/{username}', [AdminsController::class, 'update']);
        Route::delete('users/{username}', [AdminsController::class, 'destroy']);
    });
});