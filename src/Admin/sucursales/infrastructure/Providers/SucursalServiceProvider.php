<?php

namespace Src\Admin\sucursales\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Admin\sucursales\domain\Repositories\SucursalRepository;
use Src\Admin\sucursales\infrastructure\Persistence\EloquentSucursalRepository;

class SucursalServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            SucursalRepository::class,
            EloquentSucursalRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
