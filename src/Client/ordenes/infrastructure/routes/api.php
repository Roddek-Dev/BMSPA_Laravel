<?php

use Illuminate\Support\Facades\Route;
use Src\Client\ordenes\infrastructure\Http\Controllers\OrdenController;

Route::resource('ordenes', OrdenController::class);

// Ruta para obtener todas las órdenes (solo ADMIN_SUCURSAL y ADMIN_GENERAL)
Route::get('ordenes/admin/all', [OrdenController::class, 'getAllOrders'])
    ->middleware(['auth:api', 'multiple_roles:ADMIN_SUCURSAL,GERENTE']);
