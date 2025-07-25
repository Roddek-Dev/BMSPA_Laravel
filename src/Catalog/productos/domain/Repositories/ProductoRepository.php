<?php

namespace Src\Catalog\productos\domain\Repositories;

use Src\Catalog\productos\domain\Entities\Producto;

interface ProductoRepository
{
    public function findById(int $id): ?Producto;
    public function findAll(): array;
    public function save(Producto $producto): void;
    public function update(int $id, Producto $producto): void;
    public function delete(int $id): void;
}