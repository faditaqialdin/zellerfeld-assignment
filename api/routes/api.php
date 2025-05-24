<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout')
        ->middleware('auth:sanctum');

    Route::post('register', [UserController::class, 'store'])->name('user.store');
    Route::get('user/{user?}', [UserController::class, 'show'])->name('user.show')
        ->middleware('auth:sanctum');
    Route::patch('user', [UserController::class, 'update'])->name('user.update')
        ->middleware('auth:sanctum');
});
