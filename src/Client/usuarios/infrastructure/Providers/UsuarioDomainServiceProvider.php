<?php

namespace Src\Client\usuarios\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\infrastructure\Persistence\Eloquent\EloquentUsuarioRepository;
use Src\Client\usuarios\domain\Services\PasswordHasherInterface;
use Src\Client\usuarios\infrastructure\Services\LaravelPasswordHasher;
use Src\Client\usuarios\application\Auth\Handler\RegisterUsuarioHandler;
use Src\Client\usuarios\application\Auth\Handler\LoginUsuarioHandler;
use Src\Client\usuarios\application\Profile\Handler\UpdateProfileHandler;
use Src\Client\usuarios\application\Profile\Handler\ChangePasswordHandler;


class UsuarioDomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UsuarioRepositoryInterface::class,
            EloquentUsuarioRepository::class
        );

        $this->app->bind(PasswordHasherInterface::class, LaravelPasswordHasher::class);

        $this->app->when(RegisterUsuarioHandler::class)
            ->needs(PasswordHasherInterface::class)
            ->give(LaravelPasswordHasher::class);

        $this->app->when(LoginUsuarioHandler::class)
            ->needs(PasswordHasherInterface::class)
            ->give(LaravelPasswordHasher::class);

        $this->app->when(UpdateProfileHandler::class)
            ->needs(PasswordHasherInterface::class)
            ->give(LaravelPasswordHasher::class);

        $this->app->when(ChangePasswordHandler::class)
            ->needs(PasswordHasherInterface::class)
            ->give(LaravelPasswordHasher::class);
    }

    public function boot(): void {}
}
