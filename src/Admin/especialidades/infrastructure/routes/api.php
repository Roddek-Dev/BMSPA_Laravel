<?php

use Illuminate\Support\Facades\Route;
use Src\Admin\especialidades\infrastructure\Http\Controllers\EspecialidadController;

Route::middleware(['auth:api', 'role:GERENTE'])->group(function () {
    Route::resource('especialidades', EspecialidadController::class);
});
