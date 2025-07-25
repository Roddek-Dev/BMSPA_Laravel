<?php

namespace Src\Client\direcciones\application;

use Src\Client\direcciones\domain\Repositories\DireccionRepository;
use Src\Client\direcciones\domain\Entities\Direccion;

final class DireccionService
{
    public function __construct(private readonly DireccionRepository $repository)
    {
    }

    public function findAllByOwner(string $ownerType, int $ownerId): array
    {
        return $this->repository->findAllByOwner($ownerType, $ownerId);
    }

    public function findById(int $id): ?Direccion
    {
        return $this->repository->findById($id);
    }

    public function save(Direccion $direccion): void
    {
        $this->repository->save($direccion);
    }

    public function update(int $id, Direccion $direccion): void
    {
        $this->repository->update($id, $direccion);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
    
    public function setAsDefault(int $id, string $ownerType, int $ownerId): void
    {
        $this->repository->setAsDefault($id, $ownerType, $ownerId);
    }
}