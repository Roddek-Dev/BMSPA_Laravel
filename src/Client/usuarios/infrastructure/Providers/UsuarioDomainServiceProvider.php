<?php

namespace Src\Client\usuarios\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\EloquentUsuarioRepository;
use Src\Client\usuarios\domain\Services\PasswordHasherInterface;
// Elige una implementación para PasswordHasherInterface:
use Src\Client\usuarios\infrastructure\Services\LaravelPasswordHasher;
// o si prefieres la versión de Bcrypt directamente (aunque LaravelPasswordHasher ya usa bcrypt por defecto):
// use App\client\usuarios\domain\Services\BcryptPasswordHasher;

class UsuarioDomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UsuarioRepositoryInterface::class,
            EloquentUsuarioRepository::class
        );

        $this->app->bind(
            PasswordHasherInterface::class,
            LaravelPasswordHasher::class // O la implementación que elijas
        );
    }

    public function boot(): void
    {
        //
    }
}