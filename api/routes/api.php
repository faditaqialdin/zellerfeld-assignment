<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        // User profile routes
        Route::get('profile/{user?}', [UserController::class, 'profile'])->name('profile');
        Route::patch('profile', [UserController::class, 'profileUpdate'])->name('profile.update');
    });
});
