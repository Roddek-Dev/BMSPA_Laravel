<?php

use Illuminate\Support\Facades\Route;
use Src\Admin\sucursales\infrastructure\Http\Controllers\SucursalController;

Route::resource('sucursales', SucursalController::class);
