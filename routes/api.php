<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecordatorioController;
use App\Http\Controllers\Api\SucursalController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\EspecialidadController;
use App\Http\Controllers\Api\AgendamientoController;
use App\Http\Controllers\Api\OrdenController;
use App\Http\Controllers\Api\PromocionController;
use App\Http\Controllers\Api\ReseñaController;
use App\Http\Controllers\Api\ServicioController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\PagoController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\HomeUserController;
use App\Http\Controllers\Api\AutenticacionController;
use App\Http\Controllers\Api\ErrorHandlerController;

Route::apiResource('recordatorios', RecordatorioController::class)->except(['create', 'edit']);
Route::apiResource('sucursales', SucursalController::class)->except(['create', 'edit']);
Route::apiResource('usuarios', UsuarioController::class)->except(['create', 'edit']);
Route::apiResource('categorias', CategoriaController::class)->except(['create', 'edit']);
Route::apiResource('especialidades', EspecialidadController::class)->except(['create', 'edit']);
Route::apiResource('agendamientos', AgendamientoController::class)->except(['create', 'edit']);
Route::apiResource('ordenes', OrdenController::class)->except(['create', 'edit']);
Route::apiResource('promociones', PromocionController::class)->except(['create', 'edit']);
Route::apiResource('reseñas', ReseñaController::class)->except(['create', 'edit']);
Route::apiResource('servicios', ServicioController::class)->except(['create', 'edit']);
Route::apiResource('productos', ProductoController::class)->except(['create', 'edit']);

Route::apiResource('pagos', PagoController::class)->except(['create', 'edit']);
Route::apiResource('admin', AdminController::class)->except(['create', 'edit']);
Route::apiResource('home-users', HomeUserController::class)->except(['create', 'edit']);
Route::apiResource('autenticacion', AutenticacionController::class)->except(['create', 'edit']);
Route::apiResource('error-handler', ErrorHandlerController::class)->except(['create', 'edit']);
