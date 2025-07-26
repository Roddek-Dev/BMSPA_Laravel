<?php

namespace Src\Client\musica_preferencias_navegacion\domain\Repositories;

use Src\Client\musica_preferencias_navegacion\domain\Entities\MusicaPreferenciaNavegacion;

interface MusicaPreferenciaNavegacionRepository
{
    public function findById(int $id): ?MusicaPreferenciaNavegacion;
    public function findAll(): array;
    public function save(MusicaPreferenciaNavegacion $preferencia): void;
    public function update(int $id, MusicaPreferenciaNavegacion $preferencia): void;
    public function delete(int $id): void;
}