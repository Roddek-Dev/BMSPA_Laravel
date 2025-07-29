<?php

use Illuminate\Support\Facades\Route;
use Src\Client\reseñas\infrastructure\Http\Controllers\ReseñaController;

// RUTA PÚBLICA: Para que cualquiera vea las reseñas de un item. No requiere autenticación.
Route::get('reviews/public', [ReseñaController::class, 'getPublicReviews']);

// Rutas para Clientes (requiere autenticación)
Route::middleware(['auth:api'])->group(function () {
    Route::get('reviews', [ReseñaController::class, 'index']);
    Route::post('reviews', [ReseñaController::class, 'store']);
    // Rutas simples con {id}
    Route::put('reviews/{id}', [ReseñaController::class, 'update']);
    Route::delete('reviews/{id}', [ReseñaController::class, 'destroy']);
});

// Ruta de Moderación para Administradores (requiere rol específico)
Route::middleware(['auth:api', 'role:GERENTE,ADMIN_SUCURSAL'])->group(function () {
    Route::put('reviews/{reseña}/aprobar', [ReseñaController::class, 'approve']);
});
