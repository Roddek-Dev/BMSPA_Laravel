<?php

namespace Src\Admin\categorias\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Admin\categorias\domain\Repositories\CategoriaRepository;
use Src\Admin\categorias\infrastructure\Persistence\EloquentCategoriaRepository;

class CategoriaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CategoriaRepository::class,
            EloquentCategoriaRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}