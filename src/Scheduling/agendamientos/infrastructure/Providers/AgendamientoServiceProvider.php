<?php

namespace Src\Scheduling\agendamientos\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Scheduling\agendamientos\domain\Repositories\AgendamientoRepository;
use Src\Scheduling\agendamientos\infrastructure\Persistence\EloquentAgendamientoRepository;

class AgendamientoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AgendamientoRepository::class,
            EloquentAgendamientoRepository::class
        );
    }
}