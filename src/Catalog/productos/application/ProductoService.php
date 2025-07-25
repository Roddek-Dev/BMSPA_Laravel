<?php

namespace Src\Catalog\productos\application;

use Src\Catalog\productos\domain\Repositories\ProductoRepository;
use Src\Catalog\productos\domain\Entities\Producto;

final class ProductoService
{
    public function __construct(private readonly ProductoRepository $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?Producto
    {
        return $this->repository->findById($id);
    }

    public function save(Producto $producto): void
    {
        $this->repository->save($producto);
    }

    public function update(int $id, Producto $producto): void
    {
        $this->repository->update($id, $producto);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}