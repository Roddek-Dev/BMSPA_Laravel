<?php

use Illuminate\Support\Facades\Route;
use Src\Client\recordatorios\infrastructure\Http\Controllers\RecordatorioController;

Route::resource('recordatorios', RecordatorioController::class);