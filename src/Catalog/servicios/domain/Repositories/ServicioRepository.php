<?php

namespace Src\Catalog\servicios\domain\Repositories;

use Src\Catalog\servicios\domain\Entities\Servicio;

interface ServicioRepository
{
    public function findById(int $id): ?Servicio;
    public function findAll(): array;
    public function save(Servicio $servicio): void;
    public function update(int $id, Servicio $servicio): void;
    public function delete(int $id): void;
}