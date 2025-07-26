<?php

use Illuminate\Support\Facades\Route;
use Src\Catalog\servicios\infrastructure\Http\Controllers\ServicioController;

Route::middleware(['auth:api', 'role:GERENTE,ADMIN_SUCURSAL'])->group(function () {
    Route::resource('servicios', ServicioController::class);
});