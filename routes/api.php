<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UserController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);

Route::middleware('auth:sanctum')->group(function () {
    // Untuk user yang sedang login
    Route::get('/user', [UserController::class, 'currentUser']);
    Route::any('/profile', [UserController::class, 'updateProfile']);
    Route::any('/user/update', [UserController::class, 'updateProfile']);
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout']);

    // CRUD user 
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::any('/users/update/{id}', [UserController::class, 'update']); 
});