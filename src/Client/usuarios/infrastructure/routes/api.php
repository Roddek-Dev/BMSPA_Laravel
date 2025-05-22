<?php

use Illuminate\Support\Facades\Route;
use App\Client\usuarios\infrastructure\Http\Controllers\AuthController;

// Rutas de autenticación
Route::prefix('auth')->group(function () {
    // Rutas públicas
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Rutas protegidas
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // Rutas para administradores
        Route::middleware('check.role:ADMIN_GENERAL')->group(function () {
            // Aquí van las rutas que solo pueden acceder los administradores generales
        });
        
        // Rutas para empleados
        Route::middleware('check.role:EMPLEADO')->group(function () {
            // Aquí van las rutas que solo pueden acceder los empleados
        });
        
        // Rutas para clientes
        Route::middleware('check.role:CLIENTE')->group(function () {
            // Aquí van las rutas que solo pueden acceder los clientes
        });
    });
});

//use Src\Client\usuarios\infrastructure\controllers\ExampleGETController;

// Simpele route example
// Route::get('/', [ExampleGETController::class, 'index']);

//Authenticathed route example
// Route::middleware(['auth:sanctum','activitylog'])->get('/', [ExampleGETController::class, 'index']);