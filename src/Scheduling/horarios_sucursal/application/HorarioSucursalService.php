<?php

namespace Src\Scheduling\horarios_sucursal\application;

use Src\Scheduling\horarios_sucursal\domain\Repositories\HorarioSucursalRepository;
use Src\Scheduling\horarios_sucursal\domain\Entities\HorarioSucursal;

final class HorarioSucursalService
{
    public function __construct(private readonly HorarioSucursalRepository $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?HorarioSucursal
    {
        return $this->repository->findById($id);
    }

    public function save(HorarioSucursal $horario): void
    {
        $this->repository->save($horario);
    }

    public function update(int $id, HorarioSucursal $horario): void
    {
        $this->repository->update($id, $horario);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}