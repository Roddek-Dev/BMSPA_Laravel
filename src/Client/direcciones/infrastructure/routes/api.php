<?php

use Illuminate\Support\Facades\Route;
use Src\Client\direcciones\infrastructure\Http\Controllers\DireccionController;

Route::middleware('auth:api')->group(function () {
    Route::post('direcciones/{id}/default', [DireccionController::class, 'setAsDefault']);
    Route::apiResource('direcciones', DireccionController::class);
});