<?php

use Illuminate\Support\Facades\Route;
use Src\Scheduling\agendamientos\infrastructure\Http\Controllers\AgendamientoController;

Route::resource('agendamientos', AgendamientoController::class);