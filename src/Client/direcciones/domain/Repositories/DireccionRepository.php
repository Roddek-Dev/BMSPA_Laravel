<?php

namespace Src\Client\direcciones\domain\Repositories;

use Src\Client\direcciones\domain\Entities\Direccion;

interface DireccionRepository
{
    public function findById(int $id): ?Direccion;
    
    /**
     * Encuentra todas las direcciones asociadas a un "dueño" (owner) específico.
     *
     * @param string $ownerType El tipo de modelo dueño (ej. UsuarioModel::class).
     * @param int $ownerId El ID del dueño.
     * @return array
     */
    public function findAllByOwner(string $ownerType, int $ownerId): array;
    
    public function save(Direccion $direccion): void;
    
    public function delete(int $id): void;
    
    public function update(int $id, Direccion $direccion): void;

    /**
     * Establece una dirección como predeterminada para un "dueño" (owner) específico.
     *
     * @param int $id El ID de la dirección a establecer como predeterminada.
     * @param string $ownerType El tipo de modelo dueño.
     * @param int $ownerId El ID del dueño.
     */
    public function setAsDefault(int $id, string $ownerType, int $ownerId): void;
}