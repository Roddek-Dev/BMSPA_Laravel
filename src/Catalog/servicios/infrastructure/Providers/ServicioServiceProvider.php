<?php

namespace Src\Catalog\servicios\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Catalog\servicios\domain\Repositories\ServicioRepository;
use Src\Catalog\servicios\infrastructure\Persistence\EloquentServicioRepository;

class ServicioServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ServicioRepository::class,
            EloquentServicioRepository::class
        );
    }
}