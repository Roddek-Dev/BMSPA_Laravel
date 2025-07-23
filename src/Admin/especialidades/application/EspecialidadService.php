<?php

namespace Src\Admin\especialidades\application;

use Src\Admin\especialidades\domain\Repositories\EspecialidadRepositoryInterface;
use Src\Admin\especialidades\domain\Entities\Especialidad;

final class EspecialidadService
{
    public function __construct(private readonly EspecialidadRepositoryInterface $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?Especialidad
    {
        return $this->repository->findById($id);
    }

    public function save(Especialidad $especialidad): void
    {
        $this->repository->save($especialidad);
    }

    public function update(int $id, Especialidad $especialidad): void
    {
        $this->repository->update($id, $especialidad);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
