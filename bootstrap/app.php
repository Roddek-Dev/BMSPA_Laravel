<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // Importante para la configuración de middleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php', // Tus rutas API están aquí
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aquí es donde registras tus alias de middleware
        $middleware->alias([
            'role' => \Src\Client\usuarios\infrastructure\Http\Middleware\CheckRole::class,
            // Puedes añadir otros alias de middleware aquí si los necesitas, por ejemplo:
            // 'auth' => \App\Http\Middleware\Authenticate::class, // Ejemplo de cómo se verían otros
        ]);

        // Si necesitas añadir middleware globales o a grupos específicos, también se hace aquí.
        // Ejemplo para añadir middleware al grupo 'api' (aunque 'role' se aplica por ruta usualmente):
        // $middleware->group('api', [
        //     \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Ejemplo
        //     'throttle:api',
        //     \Illuminate\Routing\Middleware\SubstituteBindings::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configuración de excepciones
    })->withProviders([
        Src\Admin\categorias\infrastructure\Providers\CategoriaServiceProvider::class,
        Src\Admin\especialidades\infrastructure\Providers\EspecialidadServiceProvider::class,
        Src\Admin\sucursales\infrastructure\Providers\SucursalServiceProvider::class,
    ])->create();