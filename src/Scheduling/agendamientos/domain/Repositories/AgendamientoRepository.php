<?php

namespace Src\Scheduling\agendamientos\domain\Repositories;

use Src\Scheduling\agendamientos\domain\Entities\Agendamiento;

interface AgendamientoRepository
{
    public function findById(int $id): ?Agendamiento;
    public function findAll(): array;
    public function save(Agendamiento $agendamiento): void;
    public function update(int $id, Agendamiento $agendamiento): void;
    public function delete(int $id): void;
}