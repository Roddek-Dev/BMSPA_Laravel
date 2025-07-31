<?php

namespace Src\Client\ordenes\application;

use Src\Client\ordenes\domain\Repositories\OrdenRepository;
use Src\Client\ordenes\domain\Entities\Orden;

final class OrdenService
{
    public function __construct(private readonly OrdenRepository $repository)
    {
    }

    public function findById(int $id): ?Orden
    {
        return $this->repository->findById($id);
    }

    public function findAllByClient(int $clientId): array
    {
        return $this->repository->findAllByClient($clientId);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    // Modificamos para pasar los detalles al repositorio
    public function save(Orden $orden, array $detalles): Orden
    {
        return $this->repository->save($orden, $detalles);
    }

    public function update(int $id, Orden $orden): void
    {
        $this->repository->update($id, $orden);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}