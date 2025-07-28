<?php

namespace Src\Client\reseñas\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Client\reseñas\domain\Repositories\ReseñaRepository;
use Src\Client\reseñas\infrastructure\Persistence\EloquentReseñaRepository;

class ReseñaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ReseñaRepository::class,
            EloquentReseñaRepository::class
        );
    }
}