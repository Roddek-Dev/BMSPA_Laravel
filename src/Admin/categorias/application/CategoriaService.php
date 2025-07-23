<?php

namespace Src\Admin\categorias\application;

use Src\Admin\categorias\domain\Repositories\CategoriaRepository;
use Src\Admin\categorias\domain\Entities\Categoria;

final class CategoriaService
{
    public function __construct(private readonly CategoriaRepository $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?Categoria
    {
        return $this->repository->findById($id);
    }

    public function save(Categoria $categoria): void
    {
        $this->repository->save($categoria);
    }

    public function update(int $id, Categoria $categoria): void
    {
        $this->repository->update($id, $categoria);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}