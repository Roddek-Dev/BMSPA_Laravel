<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface::class,
            \Src\Client\usuarios\infrastructure\Persistence\Eloquent\EloquentUsuarioRepository::class
        );

        $this->app->bind(
            \Src\Client\usuarios\domain\Services\PasswordHasherInterface::class,
            \Src\Client\usuarios\infrastructure\Services\LaravelPasswordHasher::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
