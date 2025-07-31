<?php

use Illuminate\Support\Facades\Route;
use Src\Client\ordenes\infrastructure\Http\Controllers\OrdenController;

// Ruta para obtener todas las órdenes (solo ADMIN_SUCURSAL y GERENTE)
Route::get('ordenes/all', [OrdenController::class, 'getAllOrders'])
    ->middleware(['auth:api', 'multiple_roles:ADMIN_SUCURSAL,GERENTE']);

// Ruta temporal para debug (sin middleware de roles)
Route::get('ordenes/debug/all', [OrdenController::class, 'getAllOrders'])
    ->middleware('auth:api');

// Ruta temporal para probar el middleware con un solo rol
Route::get('ordenes/test/gerente', [OrdenController::class, 'getAllOrders'])
    ->middleware('auth:api')
    ->middleware('multiple_roles:GERENTE');

Route::middleware('auth:api')->group(function () {
    Route::resource('ordenes', OrdenController::class);
});
