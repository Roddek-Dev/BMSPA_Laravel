<?php

use Illuminate\Support\Facades\Route;
use Src\Catalog\servicios\infrastructure\Http\Controllers\ServicioController;

Route::resource('servicios', ServicioController::class);