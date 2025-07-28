<?php

use Illuminate\Support\Facades\Route;
use Src\Client\reseñas\infrastructure\Http\Controllers\ReseñaController;

// RUTA PÚBLICA: Para que cualquiera vea las reseñas de un item. No requiere autenticación.
Route::get('reseñas/public', [ReseñaController::class, 'getPublicReviews']);

// Rutas para Clientes (requiere autenticación)
Route::middleware(['auth:api'])->group(function () {
    Route::get('reseñas', [ReseñaController::class, 'index']);
    Route::post('reseñas', [ReseñaController::class, 'store']);
    // Rutas simples con {id}
    Route::put('reseñas/{id}', [ReseñaController::class, 'update']);
    Route::delete('reseñas/{id}', [ReseñaController::class, 'destroy']);
});

// Ruta de Moderación para Administradores (requiere rol específico)
Route::middleware(['auth:api', 'role:GERENTE,ADMIN_SUCURSAL'])->group(function () {
    Route::put('reseñas/{id}/aprobar', [ReseñaController::class, 'approve']);
});