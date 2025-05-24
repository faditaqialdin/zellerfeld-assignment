<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPostController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public Routes
    Route::post('auth/token', [AuthController::class, 'login'])->name('auth.token.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('auth/token', [AuthController::class, 'logout'])->name('auth.token.delete');

        Route::apiResource('profile', ProfileController::class)->only(['index', 'store']);
        Route::apiResource('users', UserController::class)->only(['show']);
        Route::apiResource('posts', PostController::class)->only(['index']);
        Route::apiResource('users/{user}/posts', UserPostController::class)->only(['index', 'store']);
    });
});


