<?php

namespace Src\Admin\personal\application;

use Src\Admin\personal\domain\Repositories\PersonalRepository;
use Src\Admin\personal\domain\Entities\Personal;
use Src\Admin\personal\domain\Exception\UsuarioYaEsEmpleadoException;
use Src\Admin\personal\domain\Exception\PersonalNotFoundException;

final class PersonalService
{
    public function __construct(private readonly PersonalRepository $repository) {}

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?Personal
    {
        return $this->repository->findById($id);
    }

    public function save(Personal $personal): void
    {
        $this->repository->save($personal);
    }

    public function update(int $id, Personal $personal): void
    {
        $this->repository->update($id, $personal);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * Promueve un cliente a empleado
     * 
     * @param int $usuarioId
     * @param int $sucursalAsignadaId
     * @return void
     * @throws UsuarioYaEsEmpleadoException
     */
    public function promoverClienteAEmpleado(int $usuarioId, int $sucursalAsignadaId): void
    {
        try {
            $this->repository->promoverClienteAEmpleado($usuarioId, $sucursalAsignadaId);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'ya es empleado')) {
                throw new UsuarioYaEsEmpleadoException();
            }
            throw $e;
        }
    }

    /**
     * Promueve un empleado a administrador de sucursal
     * 
     * @param int $personalId
     * @return void
     * @throws PersonalNotFoundException
     */
    public function promoverEmpleadoAAdmin(int $personalId): void
    {
        try {
            $this->repository->promoverEmpleadoAAdmin($personalId);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'no encontrado')) {
                throw new PersonalNotFoundException();
            }
            throw $e;
        }
    }
}
