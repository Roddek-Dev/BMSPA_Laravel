<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Auth\Handler;

use Src\Client\usuarios\application\Auth\Command\RegisterUsuarioCommand;
use Src\Client\usuarios\application\Auth\DTO\RegisteredUsuarioData;
use Src\Client\usuarios\domain\Entities\Usuario;
use Src\Client\usuarios\domain\Repositories\UsuarioRepositoryInterface;
use Src\Client\usuarios\domain\Services\PasswordHasherInterface;
use Src\Client\usuarios\domain\ValueObjects\EmailUsuario;
use Src\Client\usuarios\domain\ValueObjects\NombreUsuario;
use Src\Client\usuarios\domain\ValueObjects\PasswordHashed;
use Src\Client\usuarios\domain\ValueObjects\UsuarioId;

final class RegisterUsuarioHandler
{
    public function __construct(
        private UsuarioRepositoryInterface $repository,
        private PasswordHasherInterface $passwordHasher
    ) {}
    public function handle(RegisterUsuarioCommand $command): RegisteredUsuarioData
    {
        $email = new EmailUsuario($command->email());

        if ($this->repository->exists($email)) {
            throw new \DomainException('El email ya está registrado');
        }

        $hashedPassword = $this->passwordHasher->hash($command->password());
        
        try {
            $usuario = new Usuario(
                null,
                new NombreUsuario($command->nombre()),
                $email,
                new PasswordHashed($hashedPassword),
                $command->telefono()
            );
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }

        $persistedUsuario = $this->repository->save($usuario);

        return new RegisteredUsuarioData(
            $persistedUsuario->id()->value(),
            $persistedUsuario->nombre()->value(),
            $persistedUsuario->email()->value()
        );
    }
} 