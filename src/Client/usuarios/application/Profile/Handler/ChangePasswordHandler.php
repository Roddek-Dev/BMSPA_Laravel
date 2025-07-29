<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Profile\Handler;

use Src\Client\usuarios\application\Profile\Command\ChangePasswordCommand;
use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\domain\Services\PasswordHasherInterface;
use Src\Client\usuarios\domain\ValueObjects\UsuarioId;
use Src\Client\usuarios\domain\ValueObjects\PasswordHashed;
use Src\Client\usuarios\domain\Entities\Usuario;
use Src\Client\usuarios\domain\Exception\UsuarioNotFoundException;
use Src\Client\usuarios\domain\Exception\InvalidCredentialsException;

final class ChangePasswordHandler
{
    public function __construct(
        private UsuarioRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function handle(ChangePasswordCommand $command): void
    {
        $usuarioId = new UsuarioId($command->userId());
        $usuario = $this->repository->findById($usuarioId);

        if (!$usuario) {
            throw new UsuarioNotFoundException('Usuario no encontrado');
        }

        // Verificar la contraseña actual
        if (!$this->passwordHasher->verify($command->currentPassword(), $usuario->password()->value())) {
            throw new InvalidCredentialsException('La contraseña actual es incorrecta');
        }

        // Crear nueva contraseña hasheada
        $newPasswordHash = $this->passwordHasher->hash($command->newPassword());

        // CORRECTO: Llamar al método de la entidad para cambiar la contraseña
        $usuario->cambiarPassword(new PasswordHashed($newPasswordHash));

        // Guardar la entidad modificada
        $this->repository->save($usuario);
    }
}
