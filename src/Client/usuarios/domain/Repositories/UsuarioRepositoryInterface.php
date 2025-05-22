<?php

declare(strict_types=1);

namespace App\Client\usuarios\domain\Repositories;

use App\Client\usuarios\domain\Entities\Usuario;
use App\Client\usuarios\domain\ValueObjects\UsuarioId;
use App\Client\usuarios\domain\ValueObjects\EmailUsuario;

interface UsuarioRepositoryInterface
{
    public function save(Usuario $usuario): void;
    public function findById(UsuarioId $id): ?Usuario;
    public function findByEmail(EmailUsuario $email): ?Usuario;
    public function delete(UsuarioId $id): void;
    public function update(Usuario $usuario): void;
    public function exists(EmailUsuario $email): bool;
} 