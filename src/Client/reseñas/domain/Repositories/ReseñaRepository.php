<?php

namespace Src\Client\reseñas\domain\Repositories;

use Src\Client\reseñas\domain\Entities\Reseña;

interface ReseñaRepository
{
    public function findById(int $id): ?Reseña;
    public function findAllByClient(int $clientId): array;
    public function save(Reseña $reseña): void;
    public function update(int $id, Reseña $reseña): void;
    public function delete(int $id): void;
    // NUEVO MÉTODO
    public function findAllApprovedByItem(string $itemType, int $itemId): array;
    // NUEVO MÉTODO PARA ADMIN
    public function findAllPendingApproval(): array;
}