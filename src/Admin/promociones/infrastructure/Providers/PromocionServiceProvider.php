<?php

namespace Src\Admin\promociones\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Admin\promociones\domain\Repositories\PromocionRepository;
use Src\Admin\promociones\infrastructure\Persistence\EloquentPromocionRepository;

class PromocionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PromocionRepository::class,
            EloquentPromocionRepository::class
        );
    }
}