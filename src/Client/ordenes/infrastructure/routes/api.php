<?php

use Illuminate\Support\Facades\Route;
use Src\Client\ordenes\infrastructure\Http\Controllers\OrdenController;

Route::middleware(['auth:api'])->group(function () {
    // Para las órdenes, usamos Route::resource y forzamos el parámetro a 'id'
    // para mantener la consistencia con los otros CRUDs que funcionan bien.
    Route::resource('ordenes', OrdenController::class)
        ->parameters(['ordenes' => 'id'])
        ->except(['create', 'edit']);
});