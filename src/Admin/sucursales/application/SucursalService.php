<?php

namespace Src\Admin\sucursales\application;

use Src\Admin\sucursales\domain\Repositories\SucursalRepository;
use Src\Admin\sucursales\domain\Entities\Sucursal;

final class SucursalService
{
    public function __construct(private readonly SucursalRepository $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function find(int $id): ?Sucursal
    {
        return $this->repository->find($id);
    }

    public function create(Sucursal $sucursal): Sucursal
    {
        return $this->repository->create($sucursal);
    }

    public function update(int $id, Sucursal $sucursal): Sucursal
    {
        return $this->repository->update($id, $sucursal);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
