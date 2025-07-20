<?php


Route::prefix('Admin_recordatorios')->group(base_path('src/Admin/recordatorios/infrastructure/routes/api.php'));

Route::prefix('Admin_personal')->group(base_path('src/Admin/personal/infrastructure/routes/api.php'));

Route::prefix('Admin_sucursales')->group(base_path('src/Admin/sucursales/infrastructure/routes/api.php'));

Route::prefix('Admin_promociones')->group(base_path('src/Admin/promociones/infrastructure/routes/api.php'));

Route::prefix('Admin_categorias')->group(base_path('src/Admin/categorias/infrastructure/routes/api.php'));

Route::prefix('Admin_especialidades')->group(base_path('src/Admin/especialidades/infrastructure/routes/api.php'));

Route::prefix('Admin_promocion_servicio')->group(base_path('src/Admin/promocion_servicio/infrastructure/routes/api.php'));

Route::prefix('Admin_producto_promocion')->group(base_path('src/Admin/producto_promocion/infrastructure/routes/api.php'));

Route::prefix('Admin_especialidad_personal')->group(base_path('src/Admin/especialidad_personal/infrastructure/routes/api.php'));

Route::prefix('Admin_servicio_sucursal')->group(base_path('src/Admin/servicio_sucursal/infrastructure/routes/api.php'));

Route::prefix('Client_usuarios')->group(base_path('src/Client/usuarios/infrastructure/routes/api.php'));

Route::prefix('Client_ordenes')->group(base_path('src/Client/ordenes/infrastructure/routes/api.php'));

Route::prefix('Client_detalle_ordenes')->group(base_path('src/Client/detalle_ordenes/infrastructure/routes/api.php'));

Route::prefix('Client_reseñas')->group(base_path('src/Client/reseñas/infrastructure/routes/api.php'));

Route::prefix('Client_musica_preferencias_navegacion')->group(base_path('src/Client/musica_preferencias_navegacion/infrastructure/routes/api.php'));

Route::prefix('Scheduling_agendamientos')->group(base_path('src/Scheduling/agendamientos/infrastructure/routes/api.php'));

Route::prefix('Scheduling_horarios_sucursal')->group(base_path('src/Scheduling/horarios_sucursal/infrastructure/routes/api.php'));

Route::prefix('Scheduling_excepciones_horario_sucursal')->group(base_path('src/Scheduling/excepciones_horario_sucursal/infrastructure/routes/api.php'));

Route::prefix('Catalog_productos')->group(base_path('src/Catalog/productos/infrastructure/routes/api.php'));

Route::prefix('Catalog_servicios')->group(base_path('src/Catalog/servicios/infrastructure/routes/api.php'));

Route::prefix('Payments_transacciones_pago')->group(base_path('src/Payments/transacciones_pago/infrastructure/routes/api.php'));
