<?php

use Illuminate\Support\Facades\Route;
use Src\Admin\personal\infrastructure\Http\Controllers\PersonalController;

Route::middleware(['auth:api', 'role:GERENTE'])->group(function () {
    Route::resource('personal', PersonalController::class);
});