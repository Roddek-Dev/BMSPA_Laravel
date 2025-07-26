<?php

namespace Src\Client\musica_preferencias_navegacion\infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Client\musica_preferencias_navegacion\domain\Repositories\MusicaPreferenciaNavegacionRepository;
use Src\Client\musica_preferencias_navegacion\infrastructure\Persistence\EloquentMusicaPreferenciaNavegacionRepository;

class MusicaPreferenciaNavegacionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            MusicaPreferenciaNavegacionRepository::class,
            EloquentMusicaPreferenciaNavegacionRepository::class
        );
    }
}