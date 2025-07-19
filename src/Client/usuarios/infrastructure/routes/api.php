<?php

use Illuminate\Support\Facades\Route;
use Src\Client\usuarios\infrastructure\Http\Controllers\AuthController;
use Src\Client\usuarios\infrastructure\Http\Controllers\TestRoleController;
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
        
        // Rutas para administradores
        Route::middleware('check.role:ADMIN_GENERAL')->group(function () {
            Route::get('/test-admin', [TestRoleController::class, 'testAdmin']);
        });
        
        // Rutas para empleados
        Route::middleware('check.role:EMPLEADO')->group(function () {
            Route::get('/test-empleado', [TestRoleController::class, 'testEmpleado']);
        });
        
        // Rutas para clientes
        Route::middleware('check.role:CLIENTE')->group(function () {
            Route::get('/test-cliente', [TestRoleController::class, 'testCliente']);
        });
    });
});
