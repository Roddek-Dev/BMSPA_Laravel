<?php

namespace Src\Admin\especialidades\domain\Repositories;

use Src\Admin\especialidades\domain\Entities\Especialidad;

interface EspecialidadRepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id): ?Especialidad;
    public function save(Especialidad $especialidad): void;
    public function update(int $id, Especialidad $especialidad): void;
    public function delete(int $id): void;
}
