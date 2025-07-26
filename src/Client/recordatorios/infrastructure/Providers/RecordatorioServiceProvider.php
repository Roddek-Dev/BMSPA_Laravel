<?php

namespace Src\Client\recordatorios\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Client\recordatorios\domain\Repositories\RecordatorioRepository;
use Src\Client\recordatorios\infrastructure\Persistence\EloquentRecordatorioRepository;

class RecordatorioServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            RecordatorioRepository::class,
            EloquentRecordatorioRepository::class
        );
    }
}