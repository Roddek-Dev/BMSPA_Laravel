<?php

use Illuminate\Support\Facades\Route;
use Src\Admin\categorias\infrastructure\Http\Controllers\CategoriaController;

Route::resource('categorias', CategoriaController::class);