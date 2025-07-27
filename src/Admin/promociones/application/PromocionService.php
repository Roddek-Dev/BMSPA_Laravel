<?php

namespace Src\Admin\promociones\application;

use Src\Admin\promociones\domain\Repositories\PromocionRepository;
use Src\Admin\promociones\domain\Entities\Promocion;

final class PromocionService
{
    public function __construct(private readonly PromocionRepository $repository)
    {
    }

    public function findById(int $id): ?Promocion
    {
        return $this->repository->findById($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function save(Promocion $promocion): void
    {
        $this->repository->save($promocion);
    }

    public function update(int $id, Promocion $promocion): void
    {
        $this->repository->update($id, $promocion);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}