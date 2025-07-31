<?php

use Illuminate\Support\Facades\Route;
use Src\Admin\promociones\infrastructure\Http\Controllers\PromocionController;

Route::resource('promociones', PromocionController::class);