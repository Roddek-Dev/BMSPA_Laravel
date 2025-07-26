<?php

namespace Src\Client\musica_preferencias_navegacion\application;

use Src\Client\musica_preferencias_navegacion\domain\Repositories\MusicaPreferenciaNavegacionRepository;
use Src\Client\musica_preferencias_navegacion\domain\Entities\MusicaPreferenciaNavegacion;

final class MusicaPreferenciaNavegacionService
{
    public function __construct(private readonly MusicaPreferenciaNavegacionRepository $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?MusicaPreferenciaNavegacion
    {
        return $this->repository->findById($id);
    }

    public function save(MusicaPreferenciaNavegacion $preferencia): void
    {
        $this->repository->save($preferencia);
    }

    public function update(int $id, MusicaPreferenciaNavegacion $preferencia): void
    {
        $this->repository->update($id, $preferencia);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}