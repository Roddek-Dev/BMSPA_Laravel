<?php

namespace Src\Scheduling\agendamientos\application;

use Src\Scheduling\agendamientos\domain\Repositories\AgendamientoRepository;
use Src\Scheduling\agendamientos\domain\Entities\Agendamiento;
use Src\Scheduling\agendamientos\domain\Exception\ConflictHorarioException;

final class AgendamientoService
{
    public function __construct(private readonly AgendamientoRepository $repository) {}

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
        // Validar conflictos de horario antes de guardar
        $hasConflict = $this->repository->hasConflict(
            $agendamiento->sucursal_id,
            $agendamiento->personal_id,
            $agendamiento->fecha_hora_inicio,
            $agendamiento->fecha_hora_fin
        );

        if ($hasConflict) {
            throw new ConflictHorarioException();
        }

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
