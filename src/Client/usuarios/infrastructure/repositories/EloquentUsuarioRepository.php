<?php

declare(strict_types=1);

namespace App\Client\usuarios\infrastructure\repositories;

use App\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use App\Client\usuarios\domain\Entities\Usuario;
use App\Client\usuarios\domain\ValueObjects\UsuarioId;
use App\Client\usuarios\domain\ValueObjects\EmailUsuario;

class EloquentUsuarioRepository implements UsuarioRepositoryInterface
{
    public function save(Usuario $usuario): void
    {
        // Implementación pendiente
    }

    public function findById(UsuarioId $id): ?Usuario
    {
        // Implementación pendiente
        return null;
    }

    public function findByEmail(EmailUsuario $email): ?Usuario
    {
        // Implementación pendiente
        return null;
    }

    public function delete(UsuarioId $id): void
    {
        // Implementación pendiente
    }

    public function update(Usuario $usuario): void
    {
        // Implementación pendiente
    }

    public function exists(EmailUsuario $email): bool
    {
        // Implementación pendiente
        return false;
    }
} 