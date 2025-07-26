<?php

use Illuminate\Support\Facades\Route;
use Src\Client\recordatorios\infrastructure\Http\Controllers\RecordatorioController;

Route::middleware(['auth:api'])->group(function () {
    // Un cliente solo debería poder gestionar sus propios recordatorios.
    // En una implementación real, se añadiría lógica para filtrar por el ID del usuario autenticado.
    Route::resource('recordatorios', RecordatorioController::class);
});