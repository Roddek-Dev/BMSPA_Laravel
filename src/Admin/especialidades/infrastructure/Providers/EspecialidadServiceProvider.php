<?php

namespace Src\Admin\especialidades\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Admin\especialidades\domain\Repositories\EspecialidadRepositoryInterface;
use Src\Admin\especialidades\infrastructure\Persistence\EloquentEspecialidadRepository;

class EspecialidadServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            EspecialidadRepositoryInterface::class,
            EloquentEspecialidadRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
