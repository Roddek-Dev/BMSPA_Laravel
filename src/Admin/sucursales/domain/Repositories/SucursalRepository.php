<?php

namespace Src\Admin\sucursales\domain\Repositories;

use Src\Admin\sucursales\domain\Entities\Sucursal;

interface SucursalRepository
{
    public function create(Sucursal $sucursal): Sucursal;
    public function findAll(): array;
    public function find(int $id): ?Sucursal;
    public function update(int $id, Sucursal $sucursal): Sucursal;
    public function delete(int $id): void;
}
