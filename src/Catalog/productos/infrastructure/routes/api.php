<?php

use Illuminate\Support\Facades\Route;
use Src\Catalog\productos\infrastructure\Http\Controllers\ProductoController;

Route::resource('productos', ProductoController::class);

