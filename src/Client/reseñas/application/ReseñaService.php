<?php

namespace Src\Client\reseñas\application;

use Src\Client\reseñas\domain\Repositories\ReseñaRepository;
use Src\Client\reseñas\domain\Entities\Reseña;

final class ReseñaService
{
    // CORRECCIÓN: Definimos la propiedad del repositorio que usará la clase.
    private readonly ReseñaRepository $repository;

    // El constructor ahora asigna el repositorio inyectado a la propiedad de la clase.
    public function __construct(ReseñaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findById(int $id): ?Reseña
    {
        return $this->repository->findById($id);
    }

    public function findAllByClient(int $clientId): array
    {
        return $this->repository->findAllByClient($clientId);
    }

    public function save(Reseña $reseña): void
    {
        $this->repository->save($reseña);
    }

    public function update(int $id, Reseña $reseña): void
    {
        $this->repository->update($id, $reseña);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    // El método que faltaba en el servicio.
    public function findAllApprovedByItem(string $itemType, int $itemId): array
    {
        return $this->repository->findAllApprovedByItem($itemType, $itemId);
    }
}