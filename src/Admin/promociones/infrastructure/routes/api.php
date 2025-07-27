<?php

use Illuminate\Support\Facades\Route;
use Src\Admin\promociones\infrastructure\Http\Controllers\PromocionController;

Route::middleware(['auth:api', 'role:GERENTE'])->group(function () {
    // Usamos el singular 'promocione' como Laravel lo infiere para el parámetro de la ruta
    Route::resource('promociones', PromocionController::class)->parameters([
        'promociones' => 'id'
    ]);
});