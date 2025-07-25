<?php

namespace Src\Scheduling\horarios_sucursal\domain\Repositories;

use Src\Scheduling\horarios_sucursal\domain\Entities\HorarioSucursal;

interface HorarioSucursalRepository
{
    public function findById(int $id): ?HorarioSucursal;
    public function findAll(): array;
    public function save(HorarioSucursal $horario): void;
    public function update(int $id, HorarioSucursal $horario): void;
    public function delete(int $id): void;
}