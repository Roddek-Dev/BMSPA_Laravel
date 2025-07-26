<?php

use Illuminate\Support\Facades\Route;
use Src\Scheduling\agendamientos\infrastructure\Http\Controllers\AgendamientoController;

Route::middleware(['auth:api', 'role:GERENTE,ADMIN_SUCURSAL,EMPLEADO'])->group(function () {
    Route::resource('agendamientos', AgendamientoController::class);
});