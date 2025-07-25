<?php

namespace Src\Catalog\productos\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Catalog\productos\domain\Repositories\ProductoRepository;
use Src\Catalog\productos\infrastructure\Persistence\EloquentProductoRepository;

class ProductoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProductoRepository::class,
            EloquentProductoRepository::class
        );
    }
}