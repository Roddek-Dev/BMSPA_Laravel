<?php

namespace Src\Admin\categorias\domain\Repositories;

use Src\Admin\categorias\domain\Entities\Categoria;

interface CategoriaRepository
{
    public function findById(int $id): ?Categoria;
    public function findAll(): array;
    public function save(Categoria $categoria): void;
    public function delete(int $id): void;
    public function update(int $id, Categoria $categoria): void;
}