<?php

use Illuminate\Support\Facades\Route;
use Src\Admin\categorias\infrastructure\Http\Controllers\CategoriaController;

Route::middleware(['auth:api', 'role:GERENTE'])->group(function () {
    Route::resource('categorias', CategoriaController::class);
});