<?php

namespace Src\Scheduling\agendamientos\application;

use Src\Scheduling\agendamientos\domain\Repositories\AgendamientoRepository;
use Src\Scheduling\agendamientos\domain\Entities\Agendamiento;

final class AgendamientoService
{
    public function __construct(private readonly AgendamientoRepository $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?Agendamiento
    {
        return $this->repository->findById($id);
    }

    public function save(Agendamiento $agendamiento): void
    {
        $this->repository->save($agendamiento);
    }

    public function update(int $id, Agendamiento $agendamiento): void
    {
        $this->repository->update($id, $agendamiento);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}