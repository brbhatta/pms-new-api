<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Http\Controllers\UserController;
use Modules\User\Http\Controllers\UserProfileController;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('current-user', [UserController::class, 'currentUser']);
        Route::apiResource('users', UserController::class)->names('user')
            ->only(['index', 'store', 'update', 'destroy']);

        Route::post('users/{userId}/profile', [UserProfileController::class, 'store']);
        Route::get('users/{userId}/profile', [UserProfileController::class, 'show']);
        Route::put('users/{userId}/profile', [UserProfileController::class, 'update']);
    });
});
