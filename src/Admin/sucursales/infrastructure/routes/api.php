<?php

use Illuminate\Support\Facades\Route;
use Src\Admin\sucursales\infrastructure\Http\Controllers\SucursalController;

Route::middleware(['auth:api', 'role:GERENTE'])->group(function () {
    Route::resource('sucursales', SucursalController::class);
});
