<?php

namespace Src\Scheduling\horarios_sucursal\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Scheduling\horarios_sucursal\domain\Repositories\HorarioSucursalRepository;
use Src\Scheduling\horarios_sucursal\infrastructure\Persistence\EloquentHorarioSucursalRepository;

class HorarioSucursalServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            HorarioSucursalRepository::class,
            EloquentHorarioSucursalRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}