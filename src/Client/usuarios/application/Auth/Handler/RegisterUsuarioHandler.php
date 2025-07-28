<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Auth\Handler;

use Src\Client\usuarios\application\Auth\Command\RegisterUsuarioCommand;
use Src\Client\usuarios\application\Auth\DTO\RegisteredUsuarioData;

use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\domain\Services\PasswordHasherInterface;
use Src\Client\usuarios\domain\Entities\Usuario;
use Src\Client\usuarios\domain\ValueObjects\EmailUsuario;
use Src\Client\usuarios\domain\ValueObjects\NombreUsuario;
use Src\Client\usuarios\domain\ValueObjects\PasswordHashed;
use Src\Client\usuarios\domain\ValueObjects\UsuarioId;

class RegisterUsuarioHandler
{
    public function __construct(
        private readonly UsuarioRepositoryInterface $repository,
        private readonly PasswordHasherInterface $passwordHasher
    ) {
    }

    public function handle(RegisterUsuarioCommand $command): RegisteredUsuarioData
    {
        $hashedPassword = $this->passwordHasher->hash($command->getPassword());

        $usuario = new Usuario(
            new UsuarioId(null),
            new NombreUsuario($command->getNombre()),
            new EmailUsuario($command->getEmail()),
            new PasswordHashed($hashedPassword),
            $command->getTelefono(),
            'CLIENTE',
            true,
            $command->getImagenPath()
        );

        $this->repository->save($usuario);

        // Devolvemos los datos del usuario registrado
        $registeredUsuario = $this->repository->findByEmail($usuario->email());
        return new RegisteredUsuarioData(
            $registeredUsuario->id()->value(),
            $registeredUsuario->nombre()->value(),
            $registeredUsuario->email()->value(),
            $registeredUsuario->telefono(),
            $registeredUsuario->rol(),
            $registeredUsuario->activo(),
            $registeredUsuario->imagenPath()
        );
    }
}