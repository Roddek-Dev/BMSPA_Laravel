<?php

use Illuminate\Support\Facades\Route;
use Src\Scheduling\horarios_sucursal\infrastructure\Http\Controllers\HorarioSucursalController;

    Route::resource('horarios', HorarioSucursalController::class);