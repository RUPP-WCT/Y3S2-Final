<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Users\AccountRolesController;
use App\Http\Controllers\Users\AccountStatusesController;
use App\Http\Controllers\Users\AdminsController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Route;


// PUBLIC ROUTES ========================================================================


Route::prefix('auth')->group(function () {
    Route::middleware(['throttle:10,1'])->group(function () {
        Route::middleware(['status:1'])->group(function () {
            Route::post('login', [AuthController::class, 'login']);
        });
        Route::post('register', [UsersController::class, 'create']);
    });
});

Route::middleware(['throttle:120,1'])->group(function () {
    Route::get('account-roles', [AccountRolesController::class, 'index']);
    Route::get('account-statuses', [AccountStatusesController::class, 'index']);
});




// PRIVATE ROUTES ========================================================================

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