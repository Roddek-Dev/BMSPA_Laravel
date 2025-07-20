<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar las rutas de tu aplicación de manera centralizada.
    | Esto facilita el mantenimiento y la configuración de rutas.
    |
    */
    
    'prefixes' => [
        'admin' => [
            'recordatorios' => 'Admin_recordatorios',
            'personal' => 'Admin_personal',
            'sucursales' => 'Admin_sucursales',
            'promociones' => 'Admin_promociones',
            'categorias' => 'Admin_categorias',
            'especialidades' => 'Admin_especialidades',
            'promocion_servicio' => 'Admin_promocion_servicio',
            'producto_promocion' => 'Admin_producto_promocion',
            'especialidad_personal' => 'Admin_especialidad_personal',
            'servicio_sucursal' => 'Admin_servicio_sucursal',
        ],
        'client' => [
            'usuarios' => 'Client_usuarios',
            'ordenes' => 'Client_ordenes',
            'detalle_ordenes' => 'Client_detalle_ordenes',
            'reseñas' => 'Client_reseñas',
            'musica_preferencias_navegacion' => 'Client_musica_preferencias_navegacion',
        ],
        'scheduling' => [
            'agendamientos' => 'Scheduling_agendamientos',
            'horarios_sucursal' => 'Scheduling_horarios_sucursal',
            'excepciones_horario_sucursal' => 'Scheduling_excepciones_horario_sucursal',
        ],
        'catalog' => [
            'productos' => 'Catalog_productos',
            'servicios' => 'Catalog_servicios',
        ],
        'payments' => [
            'transacciones_pago' => 'Payments_transacciones_pago',
        ],
    ],
    
    'base_path' => 'src',
]; 