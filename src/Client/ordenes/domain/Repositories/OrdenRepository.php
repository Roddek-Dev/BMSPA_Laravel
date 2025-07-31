<?php

namespace Src\Client\ordenes\domain\Repositories;

use Src\Client\ordenes\domain\Entities\Orden;

interface OrdenRepository
{
    public function findById(int $id): ?Orden;
    public function findAllByClient(int $clientId): array;
    public function findAll(): array;
    // Modificamos la firma para aceptar los detalles
    public function save(Orden $orden, array $detalles): Orden;
    public function update(int $id, Orden $orden): void;
    public function delete(int $id): void;
}