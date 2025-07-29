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

    /**
     * Valida si existe un conflicto de horario para un nuevo agendamiento
     * 
     * @param int $sucursalId
     * @param ?int $personalId
     * @param string $fechaHoraInicio
     * @param string $fechaHoraFin
     * @return bool True si existe conflicto, false si no hay conflicto
     */
    public function hasConflict(int $sucursalId, ?int $personalId, string $fechaHoraInicio, string $fechaHoraFin): bool;
}
