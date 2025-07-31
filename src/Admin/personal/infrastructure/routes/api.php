<?php

use Illuminate\Support\Facades\Route;
use Src\Admin\personal\infrastructure\Http\Controllers\PersonalController;
use Src\Admin\personal\infrastructure\Http\Controllers\PromocionController;

Route::resource('personal', PersonalController::class);


Route::middleware(['auth:api', 'role:GERENTE'])->group(function () {

    // Rutas de promoción - solo GERENTE puede acceder
    Route::post('usuarios/{usuarioId}/promover-a-empleado', [PromocionController::class, 'promoverClienteAEmpleado']);
    Route::post('personal/{personalId}/promover-a-admin', [PromocionController::class, 'promoverEmpleadoAAdmin']);

    // Ruta para obtener todos los usuarios
    Route::get('usuarios', [PersonalController::class, 'obtenerUsuarios']);
});
