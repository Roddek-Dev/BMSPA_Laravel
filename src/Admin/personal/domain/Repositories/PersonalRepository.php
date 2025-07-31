<?php

namespace Src\Admin\personal\domain\Repositories;

use Src\Admin\personal\domain\Entities\Personal;

interface PersonalRepository
{
    public function findById(int $id): ?Personal;
    public function findAll(): array;
    public function save(Personal $personal): void;
    public function update(int $id, Personal $personal): void;
    public function delete(int $id): void;

    /**
     * Promueve un cliente a empleado
     * 
     * @param int $usuarioId
     * @param int $sucursalAsignadaId
     * @return void
     */
    public function promoverClienteAEmpleado(int $usuarioId, int $sucursalAsignadaId): void;

    /**
     * Promueve un empleado a administrador de sucursal
     * 
     * @param int $personalId
     * @return void
     */
    public function promoverEmpleadoAAdmin(int $personalId): void;

    /**
     * Verifica si un usuario ya tiene un registro en personal
     * 
     * @param int $usuarioId
     * @return bool
     */
    public function usuarioTienePersonal(int $usuarioId): bool;

    /**
     * Obtiene todos los usuarios de la base de datos
     * 
     * @return array
     */
    public function obtenerTodosLosUsuarios(): array;
}
