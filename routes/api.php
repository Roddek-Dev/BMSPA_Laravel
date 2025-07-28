<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas de la API para la aplicación. Estas rutas
| son cargadas por el RouteServiceProvider y todas se agruparán bajo
| el prefijo /api que ya está configurado.
|
*/

//==========================================================================
// CONTEXTO: Admin
// Funcionalidades para la gestión y administración del negocio.
//==========================================================================
Route::prefix('Admin_categorias')->group(base_path('src/Admin/categorias/infrastructure/routes/api.php'));
Route::prefix('Admin_especialidades')->group(base_path('src/Admin/especialidades/infrastructure/routes/api.php'));
Route::prefix('Admin_personal')->group(base_path('src/Admin/personal/infrastructure/routes/api.php'));
Route::prefix('Admin_promociones')->group(base_path('src/Admin/promociones/infrastructure/routes/api.php'));
Route::prefix('Admin_sucursales')->group(base_path('src/Admin/sucursales/infrastructure/routes/api.php'));

//==========================================================================
// CONTEXTO: Catalog
// Gestión del catálogo de productos y servicios.
//==========================================================================
Route::prefix('Catalog_productos')->group(base_path('src/Catalog/productos/infrastructure/routes/api.php'));
Route::prefix('Catalog_servicios')->group(base_path('src/Catalog/servicios/infrastructure/routes/api.php'));

//==========================================================================
// CONTEXTO: Client
// Funcionalidades orientadas al cliente final.
//==========================================================================
Route::prefix('Client_usuarios')->group(base_path('src/Client/usuarios/infrastructure/routes/api.php'));
Route::prefix('Client_ordenes')->group(base_path('src/Client/ordenes/infrastructure/routes/api.php'));
Route::prefix('Client_reseñas')->group(base_path('src/Client/reseñas/infrastructure/routes/api.php'));
Route::prefix('Client_direcciones')->group(base_path('src/Client/direcciones/infrastructure/routes/api.php'));
Route::prefix('Client_recordatorios')->group(base_path('src/Client/recordatorios/infrastructure/routes/api.php'));

//==========================================================================
// CONTEXTO: Payments
// Lógica para procesar pagos con pasarelas externas.
//==========================================================================
// TODO: Implementar el módulo de pagos. Actualmente los archivos de ruta de ejemplo fueron eliminados.
// Route::prefix('Payments_transacciones_pago')->group(base_path('src/Payments/transacciones_pago/infrastructure/routes/api.php'));

//==========================================================================
// CONTEXTO: Scheduling
// Todo lo relacionado con agendamiento de citas y horarios.
//==========================================================================
Route::prefix('Scheduling_agendamientos')->group(base_path('src/Scheduling/agendamientos/infrastructure/routes/api.php'));
Route::prefix('Scheduling_horarios_sucursal')->group(base_path('src/Scheduling/horarios_sucursal/infrastructure/routes/api.php'));

