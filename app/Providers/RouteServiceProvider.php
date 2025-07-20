<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Register all module routes automatically
     */
    public function registerModuleRoutes(): void
    {
        $routeConfig = config('routes');
        $basePath = $routeConfig['base_path'];

        foreach ($routeConfig['prefixes'] as $module => $routes) {
            foreach ($routes as $routeName => $prefix) {
                $routePath = "{$basePath}/{$module}/{$routeName}/infrastructure/routes/api.php";
                
                if (file_exists($routePath)) {
                    Route::prefix($prefix)->group(base_path($routePath));
                }
            }
        }
    }
} 