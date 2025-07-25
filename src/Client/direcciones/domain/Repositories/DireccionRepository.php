<?php

namespace Src\Client\direcciones\domain\Repositories;

use Src\Client\direcciones\domain\Entities\Direccion;

interface DireccionRepository
{
    public function findById(int $id): ?Direccion;
    public function findAllByClient(int $clientId): array;
    public function save(Direccion $direccion): void;
    public function delete(int $id): void;
    public function update(int $id, Direccion $direccion): void;
    public function setAsDefault(int $id, int $clientId): void;
}