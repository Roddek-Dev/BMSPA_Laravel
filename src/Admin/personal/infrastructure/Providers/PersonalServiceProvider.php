<?php

namespace Src\Admin\personal\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Admin\personal\domain\Repositories\PersonalRepository;
use Src\Admin\personal\infrastructure\Persistence\EloquentPersonalRepository;

class PersonalServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            PersonalRepository::class,
            EloquentPersonalRepository::class
        );
    }
}