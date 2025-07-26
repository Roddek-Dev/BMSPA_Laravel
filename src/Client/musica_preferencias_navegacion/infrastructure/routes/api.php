<?php

use Illuminate\Support\Facades\Route;
use Src\Client\musica_preferencias_navegacion\infrastructure\Http\Controllers\MusicaPreferenciaNavegacionController;

// Rutas públicas que cualquiera puede ver
Route::get('preferencias', [MusicaPreferenciaNavegacionController::class, 'index']);
Route::get('preferencias/{id}', [MusicaPreferenciaNavegacionController::class, 'show']);

// Rutas protegidas solo para Gerentes
Route::middleware(['auth:api', 'role:GERENTE'])->group(function () {
    Route::post('preferencias', [MusicaPreferenciaNavegacionController::class, 'store']);
    Route::put('preferencias/{musica_preferencia}', [MusicaPreferenciaNavegacionController::class, 'update']);
    Route::delete('preferencias/{id}', [MusicaPreferenciaNavegacionController::class, 'destroy']);
});