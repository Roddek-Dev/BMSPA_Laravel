<?php

use Illuminate\Support\Facades\Route;
use Src\Scheduling\horarios_sucursal\infrastructure\Http\Controllers\HorarioSucursalController;

Route::middleware(['auth:api', 'role:GERENTE,ADMIN_SUCURSAL'])->group(function () {
    Route::resource('horarios', HorarioSucursalController::class);
});