<?php

use Illuminate\Support\Facades\Route;
use Src\Client\usuarios\infrastructure\Http\Controllers\AuthController;
use Src\Client\usuarios\infrastructure\Http\Controllers\TestRoleController;

// Rutas de autenticación
Route::prefix('auth')->group(function () {
    // Rutas públicas
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Rutas protegidas
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // Rutas para administradores
        Route::middleware('role:ADMIN_GENERAL')->group(function () {
            Route::get('/test-admin', [TestRoleController::class, 'testAdmin']);
        });
        
        // Rutas para empleados
        Route::middleware('role:EMPLEADO')->group(function () {
            Route::get('/test-empleado', [TestRoleController::class, 'testEmpleado']);
        });
        
        // Rutas para clientes
        Route::middleware('role:CLIENTE')->group(function () {
            Route::get('/test-cliente', [TestRoleController::class, 'testCliente']);
        });
    });
});
