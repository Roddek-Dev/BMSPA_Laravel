<?php

use Illuminate\Support\Facades\Route;
use Src\Client\ordenes\infrastructure\Http\Controllers\OrdenController;

Route::resource('ordenes', OrdenController::class);