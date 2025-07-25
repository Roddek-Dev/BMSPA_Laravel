<?php

namespace Src\Client\direcciones\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Client\direcciones\domain\Repositories\DireccionRepository;
use Src\Client\direcciones\infrastructure\Persistence\EloquentDireccionRepository;

class DireccionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            DireccionRepository::class,
            EloquentDireccionRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}