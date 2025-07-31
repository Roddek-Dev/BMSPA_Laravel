<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Src\Client\usuarios\infrastructure\Http\Middleware\CheckRole::class,
            'multiple_roles' => \Src\Client\usuarios\infrastructure\Http\Middleware\CheckMultipleRoles::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {})->withProviders([
        Src\Client\usuarios\infrastructure\Providers\UsuarioDomainServiceProvider::class,
        Src\Admin\categorias\infrastructure\Providers\CategoriaServiceProvider::class,
        Src\Admin\especialidades\infrastructure\Providers\EspecialidadServiceProvider::class,
        Src\Admin\sucursales\infrastructure\Providers\SucursalServiceProvider::class,
        Src\Client\recordatorios\infrastructure\Providers\RecordatorioServiceProvider::class,
        Src\Admin\promociones\infrastructure\Providers\PromocionServiceProvider::class,
        Src\Catalog\productos\infrastructure\Providers\ProductoServiceProvider::class,
        Src\Catalog\servicios\infrastructure\Providers\ServicioServiceProvider::class,
        Src\Client\ordenes\infrastructure\Providers\OrdenServiceProvider::class,
        Src\Client\reseñas\infrastructure\Providers\ReseñaServiceProvider::class,
        Src\Scheduling\agendamientos\infrastructure\Providers\AgendamientoServiceProvider::class,
        Src\Scheduling\horarios_sucursal\infrastructure\Providers\HorarioSucursalServiceProvider::class,
        Src\Admin\personal\infrastructure\Providers\PersonalServiceProvider::class,
        Src\Client\direcciones\infrastructure\Providers\DireccionServiceProvider::class,
        Src\Payments\transacciones_pago\infrastructure\Providers\PagoDomainServiceProvider::class,

    ])->create();
