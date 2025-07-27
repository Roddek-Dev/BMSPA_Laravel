<?php

namespace Src\Client\ordenes\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Client\ordenes\domain\Repositories\OrdenRepository;
use Src\Client\ordenes\infrastructure\Persistence\EloquentOrdenRepository;

class OrdenServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            OrdenRepository::class,
            EloquentOrdenRepository::class
        );
    }
}