<?php

use Illuminate\Support\Facades\Route;
use Src\Catalog\productos\infrastructure\Http\Controllers\ProductoController;

Route::middleware(['auth:api', 'role:GERENTE,ADMIN_SUCURSAL'])->group(function () {
    Route::resource('productos', ProductoController::class);
});