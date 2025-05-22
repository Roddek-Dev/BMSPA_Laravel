<?php

declare(strict_types=1);

namespace Src\Client\usuarios\domain\Repositories;

use Src\Client\usuarios\domain\Entities\Usuario;
use Src\Client\usuarios\domain\ValueObjects\UsuarioId;
use Src\Client\usuarios\domain\ValueObjects\EmailUsuario;

interface UsuarioRepositoryInterface
{
    public function save(Usuario $usuario): Usuario; // DESPUÉS: Devolver la entidad Usuario
    public function findById(UsuarioId $id): ?Usuario;
    public function findByEmail(EmailUsuario $email): ?Usuario;
    public function delete(UsuarioId $id): void;
    public function update(Usuario $usuario): void;
    public function exists(EmailUsuario $email): bool;
} 