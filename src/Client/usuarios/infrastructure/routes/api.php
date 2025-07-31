<?php

use Illuminate\Support\Facades\Route;
use Src\Client\usuarios\infrastructure\Http\Controllers\AuthController;
use Src\Client\usuarios\infrastructure\Http\Controllers\UserController;
use Src\Client\usuarios\infrastructure\Http\Controllers\OAuthController;

// Rutas de autenticación
Route::prefix('auth')->group(function () {
    // Rutas públicas
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Rutas OAuth2
    Route::post('/oauth/login', [OAuthController::class, 'login']);
    Route::post('/oauth/refresh', [OAuthController::class, 'refresh']);

    // Rutas protegidas
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/oauth/logout', [OAuthController::class, 'logout']);
        Route::get('/oauth/me', [OAuthController::class, 'me']);
    });
});

// Rutas de perfil de usuario (protegidas)
Route::prefix('profile')->middleware('auth:api')->group(function () {
    Route::get('/', [UserController::class, 'profile']);
    Route::put('/', [UserController::class, 'updateProfile']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
});
