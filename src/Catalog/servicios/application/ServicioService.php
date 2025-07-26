<?php

namespace Src\Catalog\servicios\application;

use Src\Catalog\servicios\domain\Repositories\ServicioRepository;
use Src\Catalog\servicios\domain\Entities\Servicio;

final class ServicioService
{
    public function __construct(private readonly ServicioRepository $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?Servicio
    {
        return $this->repository->findById($id);
    }

    public function save(Servicio $servicio): void
    {
        $this->repository->save($servicio);
    }

    public function update(int $id, Servicio $servicio): void
    {
        $this->repository->update($id, $servicio);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}